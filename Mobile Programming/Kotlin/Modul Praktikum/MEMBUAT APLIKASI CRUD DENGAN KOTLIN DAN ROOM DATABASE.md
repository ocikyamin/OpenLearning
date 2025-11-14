

# MODUL CRUD SEDERHANA DENGAN KOTLIN & ROOM DATABASE  

### Target Pembelajaran
1. Membuat aplikasi CRUD sederhana
2. Menggunakan Room Database
3. Memahami operasi database dasar
4. Membuat UI yang interaktif

---

## 🛠️ PERSIAPAN

### Software yang Dibutuhkan:
- **Android Studio 2023+** (Hedgehog/Flamingo)
- **Emulator atau Android device** (API 21+)

---

## 🚀 STEP-BY-STEP TUTORIAL

### STEP 1: MEMBUAT PROJECT BARU

1. Buka Android Studio
2. **New Project** → **Empty Views Activity**
3. Konfigurasi:
   - **Name**: Simple CRUD App
   - **Package**: com.example.simplecrud
   - **Language**: Kotlin
   - **Minimum SDK**: API 21
4. **Finish**

### STEP 2: SETUP BUILD GRADLE

Buka `build.gradle.kts` (Module :app):

```kotlin
plugins {
    id("com.android.application")
    id("org.jetbrains.kotlin.android")
    id("kotlin-kapt")
}

android {
    namespace = "com.example.simplecrud"
    compileSdk = 34

    defaultConfig {
        applicationId = "com.example.simplecrud"
        minSdk = 21
        targetSdk = 34
        versionCode = 1
        versionName = "1.0"
    }

    buildTypes {
        release {
            isMinifyEnabled = false
            proguardFiles(
                getDefaultProguardFile("proguard-android-optimize.txt"),
                "proguard-rules.pro"
            )
        }
    }
    
    compileOptions {
        sourceCompatibility = JavaVersion.VERSION_1_8
        targetCompatibility = JavaVersion.VERSION_1_8
    }
    
    kotlinOptions {
        jvmTarget = "1.8"
    }
    
    buildFeatures {
        viewBinding = true
    }
}

dependencies {
    // Core Android
    implementation("androidx.core:core-ktx:1.12.0")
    implementation("androidx.appcompat:appcompat:1.6.1")
    implementation("com.google.android.material:material:1.11.0")
    implementation("androidx.constraintlayout:constraintlayout:2.1.4")
    
    // Room Database
    val roomVersion = "2.6.1"
    implementation("androidx.room:room-runtime:$roomVersion")
    kapt("androidx.room:room-compiler:$roomVersion")
    
    // Coroutines untuk operasi database
    implementation("org.jetbrains.kotlinx:kotlinx-coroutines-android:1.7.3")
    
    // Testing
    testImplementation("junit:junit:4.13.2")
    androidTestImplementation("androidx.test.ext:junit:1.1.5")
    androidTestImplementation("androidx.test.espresso:espresso-core:3.5.1")
}
```

### STEP 3: MEMBUAT PACKAGE

Klik kanan package utama → **New** → **Package** → Beri nama `database`

### STEP 4: MEMBUAT ENTITY (MODEL DATA)

Buat package `database` → **New** → **Kotlin Class** → `Note.kt`

```kotlin
package com.example.simplecrud.database

import androidx.room.Entity
import androidx.room.PrimaryKey

@Entity(tableName = "notes")
data class Note(
    @PrimaryKey(autoGenerate = true)
    val id: Int = 0,
    val title: String,
    val content: String,
    val createdAt: Long = System.currentTimeMillis()
)
```

### STEP 5: MEMBUAT DAO (DATABASE ACCESS OBJECT)

Buat package `database` → **New** → **Kotlin Interface** → `NoteDao.kt`

```kotlin
package com.example.simplecrud.database

import androidx.room.*

@Dao
interface NoteDao {
    @Insert
    suspend fun insert(note: Note): Long

    @Update
    suspend fun update(note: Note): Int

    @Delete
    suspend fun delete(note: Note): Int

    @Query("SELECT * FROM notes ORDER BY createdAt DESC")
    suspend fun getAllNotes(): List<Note>

    @Query("SELECT * FROM notes WHERE id = :id")
    suspend fun getNoteById(id: Int): Note?

    @Query("DELETE FROM notes WHERE id = :id")
    suspend fun deleteById(id: Int): Int
}
```

### STEP 6: MEMBUAT DATABASE CLASS

Buat package `database` → **New** → **Kotlin Class** → `AppDatabase.kt`

```kotlin
package com.example.simplecrud.database

import android.content.Context
import androidx.room.Database
import androidx.room.Room
import androidx.room.RoomDatabase

@Database(
    entities = [Note::class],
    version = 1,
    exportSchema = false
)
abstract class AppDatabase : RoomDatabase() {
    abstract fun noteDao(): NoteDao

    companion object {
        @Volatile
        private var INSTANCE: AppDatabase? = null

        fun getDatabase(context: Context): AppDatabase {
            return INSTANCE ?: synchronized(this) {
                val instance = Room.databaseBuilder(
                    context.applicationContext,
                    AppDatabase::class.java,
                    "simple_crud_database"
                ).build()
                INSTANCE = instance
                instance
            }
        }
    }
}
```

### STEP 7: MEMBUAT LAYOUT UTAMA

Buka `res/layout/activity_main.xml`:

```xml
<?xml version="1.0" encoding="utf-8"?>
<androidx.constraintlayout.widget.ConstraintLayout 
    xmlns:android="http://schemas.android.com/apk/res/android"
    xmlns:app="http://schemas.android.com/apk/res-auto"
    xmlns:tools="http://schemas.android.com/tools"
    android:layout_width="match_parent"
    android:layout_height="match_parent"
    tools:context=".MainActivity">

    <androidx.recyclerview.widget.RecyclerView
        android:id="@+id/recyclerViewNotes"
        android:layout_width="0dp"
        android:layout_height="0dp"
        android:padding="8dp"
        app:layout_constraintBottom_toTopOf="@+id/buttonAdd"
        app:layout_constraintEnd_toEndOf="parent"
        app:layout_constraintStart_toStartOf="parent"
        app:layout_constraintTop_toTopOf="parent"
        tools:listitem="@layout/item_note" />

    <TextView
        android:id="@+id/textViewEmpty"
        android:layout_width="wrap_content"
        android:layout_height="wrap_content"
        android:text="Belum ada catatan"
        android:textSize="16sp"
        android:visibility="gone"
        app:layout_constraintBottom_toBottomOf="parent"
        app:layout_constraintEnd_toEndOf="parent"
        app:layout_constraintStart_toStartOf="parent"
        app:layout_constraintTop_toTopOf="parent" />

    <ProgressBar
        android:id="@+id/progressBar"
        android:layout_width="wrap_content"
        android:layout_height="wrap_content"
        android:visibility="gone"
        app:layout_constraintBottom_toBottomOf="parent"
        app:layout_constraintEnd_toEndOf="parent"
        app:layout_constraintStart_toStartOf="parent"
        app:layout_constraintTop_toTopOf="parent" />

    <Button
        android:id="@+id/buttonAdd"
        android:layout_width="0dp"
        android:layout_height="wrap_content"
        android:layout_margin="16dp"
        android:text="Tambah Catatan"
        app:layout_constraintBottom_toBottomOf="parent"
        app:layout_constraintEnd_toEndOf="parent"
        app:layout_constraintStart_toStartOf="parent" />

</androidx.constraintlayout.widget.ConstraintLayout>
```

### STEP 8: MEMBUAT ITEM LAYOUT

Buat `res/layout/item_note.xml`:

```xml
<?xml version="1.0" encoding="utf-8"?>
<androidx.cardview.widget.CardView 
    xmlns:android="http://schemas.android.com/apk/res/android"
    xmlns:app="http://schemas.android.com/apk/res-auto"
    android:layout_width="match_parent"
    android:layout_height="wrap_content"
    android:layout_margin="8dp"
    app:cardCornerRadius="8dp"
    app:cardElevation="4dp">

    <LinearLayout
        android:layout_width="match_parent"
        android:layout_height="wrap_content"
        android:orientation="vertical"
        android:padding="16dp">

        <LinearLayout
            android:layout_width="match_parent"
            android:layout_height="wrap_content"
            android:orientation="horizontal">

            <TextView
                android:id="@+id/textViewTitle"
                android:layout_width="0dp"
                android:layout_height="wrap_content"
                android:layout_weight="1"
                android:textStyle="bold"
                android:textSize="16sp"
                android:textColor="@android:color/black"
                tools:text="Judul Catatan" />

            <LinearLayout
                android:layout_width="wrap_content"
                android:layout_height="wrap_content"
                android:orientation="horizontal">

                <ImageButton
                    android:id="@+id/buttonEdit"
                    android:layout_width="40dp"
                    android:layout_height="40dp"
                    android:background="?attr/selectableItemBackgroundBorderless"
                    android:src="@android:drawable/ic_menu_edit"
                    android:contentDescription="Edit" />

                <ImageButton
                    android:id="@+id/buttonDelete"
                    android:layout_width="40dp"
                    android:layout_height="40dp"
                    android:background="?attr/selectableItemBackgroundBorderless"
                    android:src="@android:drawable/ic_menu_delete"
                    android:contentDescription="Delete" />

            </LinearLayout>

        </LinearLayout>

        <TextView
            android:id="@+id/textViewContent"
            android:layout_width="match_parent"
            android:layout_height="wrap_content"
            android:layout_marginTop="8dp"
            android:maxLines="3"
            android:ellipsize="end"
            tools:text="Isi catatan akan muncul di sini..." />

        <TextView
            android:id="@+id/textViewDate"
            android:layout_width="match_parent"
            android:layout_height="wrap_content"
            android:layout_marginTop="4dp"
            android:textSize="12sp"
            android:textColor="@android:color/darker_gray"
            tools:text="2024-01-01 12:00" />

    </LinearLayout>

</androidx.cardview.widget.CardView>
```

### STEP 9: MEMBUAT ADAPTER

Buat package utama → **New** → **Kotlin Class** → `NoteAdapter.kt`

```kotlin
package com.example.simplecrud

import android.view.LayoutInflater
import android.view.View
import android.view.ViewGroup
import android.widget.ImageButton
import android.widget.TextView
import androidx.recyclerview.widget.RecyclerView
import com.example.simplecrud.database.Note
import java.text.SimpleDateFormat
import java.util.*

class NoteAdapter(
    private val onEditClick: (Note) -> Unit,
    private val onDeleteClick: (Note) -> Unit
) : RecyclerView.Adapter<NoteAdapter.NoteViewHolder>() {

    private var notes: List<Note> = emptyList()

    fun submitList(newNotes: List<Note>) {
        notes = newNotes
        notifyDataSetChanged()
    }

    override fun onCreateViewHolder(parent: ViewGroup, viewType: Int): NoteViewHolder {
        val view = LayoutInflater.from(parent.context)
            .inflate(R.layout.item_note, parent, false)
        return NoteViewHolder(view)
    }

    override fun onBindViewHolder(holder: NoteViewHolder, position: Int) {
        holder.bind(notes[position])
    }

    override fun getItemCount(): Int = notes.size

    inner class NoteViewHolder(itemView: View) : RecyclerView.ViewHolder(itemView) {
        private val textViewTitle: TextView = itemView.findViewById(R.id.textViewTitle)
        private val textViewContent: TextView = itemView.findViewById(R.id.textViewContent)
        private val textViewDate: TextView = itemView.findViewById(R.id.textViewDate)
        private val buttonEdit: ImageButton = itemView.findViewById(R.id.buttonEdit)
        private val buttonDelete: ImageButton = itemView.findViewById(R.id.buttonDelete)

        fun bind(note: Note) {
            textViewTitle.text = note.title
            textViewContent.text = note.content
            
            // Format tanggal
            val dateFormat = SimpleDateFormat("dd/MM/yyyy HH:mm", Locale.getDefault())
            textViewDate.text = dateFormat.format(Date(note.createdAt))
            
            buttonEdit.setOnClickListener { onEditClick(note) }
            buttonDelete.setOnClickListener { onDeleteClick(note) }
        }
    }
}
```

### STEP 10: MEMBUAT ACTIVITY TAMBAH/EDIT

Buat **New** → **Activity** → **Empty Activity** → `AddEditActivity.kt`

Layout `res/layout/activity_add_edit.xml`:

```xml
<?xml version="1.0" encoding="utf-8"?>
<LinearLayout 
    xmlns:android="http://schemas.android.com/apk/res/android"
    android:layout_width="match_parent"
    android:layout_height="match_parent"
    android:orientation="vertical"
    android:padding="16dp">

    <EditText
        android:id="@+id/editTextTitle"
        android:layout_width="match_parent"
        android:layout_height="wrap_content"
        android:hint="Judul Catatan"
        android:inputType="textCapSentences"
        android:maxLines="1"
        android:layout_marginBottom="16dp" />

    <EditText
        android:id="@+id/editTextContent"
        android:layout_width="match_parent"
        android:layout_height="0dp"
        android:layout_weight="1"
        android:hint="Isi Catatan"
        android:inputType="textMultiLine|textCapSentences"
        android:gravity="top"
        android:minHeight="200dp"
        android:layout_marginBottom="16dp" />

    <LinearLayout
        android:layout_width="match_parent"
        android:layout_height="wrap_content"
        android:orientation="horizontal">

        <Button
            android:id="@+id/buttonSave"
            android:layout_width="0dp"
            android:layout_height="wrap_content"
            android:layout_weight="1"
            android:text="Simpan"
            android:layout_marginEnd="8dp" />

        <Button
            android:id="@+id/buttonCancel"
            android:layout_width="0dp"
            android:layout_height="wrap_content"
            android:layout_weight="1"
            android:text="Batal"
            style="@style/Widget.MaterialComponents.Button.OutlinedButton" />

    </LinearLayout>

</LinearLayout>
```

### STEP 11: IMPLEMENTASI MAIN ACTIVITY

Buka `MainActivity.kt` dan ganti isinya:

```kotlin
package com.example.simplecrud

import android.content.Intent
import android.os.Bundle
import android.widget.Toast
import androidx.appcompat.app.AppCompatActivity
import androidx.recyclerview.widget.LinearLayoutManager
import androidx.recyclerview.widget.RecyclerView
import com.example.simplecrud.database.AppDatabase
import com.example.simplecrud.database.Note
import com.example.simplecrud.databinding.ActivityMainBinding
import kotlinx.coroutines.CoroutineScope
import kotlinx.coroutines.Dispatchers
import kotlinx.coroutines.launch
import kotlinx.coroutines.withContext

class MainActivity : AppCompatActivity() {
    
    private lateinit var binding: ActivityMainBinding
    private lateinit var database: AppDatabase
    private lateinit var noteAdapter: NoteAdapter

    override fun onCreate(savedInstanceState: Bundle?) {
        super.onCreate(savedInstanceState)
        binding = ActivityMainBinding.inflate(layoutInflater)
        setContentView(binding.root)
        
        // Inisialisasi database
        database = AppDatabase.getDatabase(this)
        
        // Setup RecyclerView
        setupRecyclerView()
        
        // Setup click listeners
        setupClickListeners()
        
        // Load data
        loadNotes()
    }
    
    private fun setupRecyclerView() {
        noteAdapter = NoteAdapter(
            onEditClick = { note ->
                // Buka activity edit dengan data note
                val intent = Intent(this, AddEditActivity::class.java).apply {
                    putExtra("NOTE_ID", note.id)
                    putExtra("NOTE_TITLE", note.title)
                    putExtra("NOTE_CONTENT", note.content)
                }
                startActivity(intent)
            },
            onDeleteClick = { note ->
                // Hapus note
                deleteNote(note)
            }
        )
        
        binding.recyclerViewNotes.apply {
            layoutManager = LinearLayoutManager(this@MainActivity)
            adapter = noteAdapter
        }
    }
    
    private fun setupClickListeners() {
        binding.buttonAdd.setOnClickListener {
            // Buka activity tambah baru
            val intent = Intent(this, AddEditActivity::class.java)
            startActivity(intent)
        }
    }
    
    private fun loadNotes() {
        // Tampilkan loading
        binding.progressBar.visibility = View.VISIBLE
        binding.textViewEmpty.visibility = View.GONE
        binding.recyclerViewNotes.visibility = View.GONE
        
        // Jalankan di background thread
        CoroutineScope(Dispatchers.IO).launch {
            try {
                val notes = database.noteDao().getAllNotes()
                
                // Update UI di main thread
                withContext(Dispatchers.Main) {
                    binding.progressBar.visibility = View.GONE
                    
                    if (notes.isEmpty()) {
                        binding.textViewEmpty.visibility = View.VISIBLE
                        binding.recyclerViewNotes.visibility = View.GONE
                    } else {
                        binding.textViewEmpty.visibility = View.GONE
                        binding.recyclerViewNotes.visibility = View.VISIBLE
                        noteAdapter.submitList(notes)
                    }
                }
            } catch (e: Exception) {
                withContext(Dispatchers.Main) {
                    binding.progressBar.visibility = View.GONE
                    Toast.makeText(this@MainActivity, "Error: ${e.message}", Toast.LENGTH_SHORT).show()
                }
            }
        }
    }
    
    private fun deleteNote(note: Note) {
        CoroutineScope(Dispatchers.IO).launch {
            try {
                database.noteDao().delete(note)
                
                // Refresh data
                loadNotes()
                
                withContext(Dispatchers.Main) {
                    Toast.makeText(this@MainActivity, "Catatan dihapus", Toast.LENGTH_SHORT).show()
                }
            } catch (e: Exception) {
                withContext(Dispatchers.Main) {
                    Toast.makeText(this@MainActivity, "Error: ${e.message}", Toast.LENGTH_SHORT).show()
                }
            }
        }
    }
    
    override fun onResume() {
        super.onResume()
        // Refresh data saat kembali dari activity lain
        loadNotes()
    }
}
```

### STEP 12: IMPLEMENTASI ADD/EDIT ACTIVITY

Buka `AddEditActivity.kt`:

```kotlin
package com.example.simplecrud

import android.os.Bundle
import android.widget.Toast
import androidx.appcompat.app.AppCompatActivity
import com.example.simplecrud.database.AppDatabase
import com.example.simplecrud.database.Note
import com.example.simplecrud.databinding.ActivityAddEditBinding
import kotlinx.coroutines.CoroutineScope
import kotlinx.coroutines.Dispatchers
import kotlinx.coroutines.launch
import kotlinx.coroutines.withContext

class AddEditActivity : AppCompatActivity() {
    
    private lateinit var binding: ActivityAddEditBinding
    private lateinit var database: AppDatabase
    private var noteId: Int = -1
    private var isEditMode = false

    override fun onCreate(savedInstanceState: Bundle?) {
        super.onCreate(savedInstanceState)
        binding = ActivityAddEditBinding.inflate(layoutInflater)
        setContentView(binding.root)
        
        // Inisialisasi database
        database = AppDatabase.getDatabase(this)
        
        // Cek mode edit atau tambah
        checkEditMode()
        
        // Setup click listeners
        setupClickListeners()
    }
    
    private fun checkEditMode() {
        noteId = intent.getIntExtra("NOTE_ID", -1)
        
        if (noteId != -1) {
            // Mode edit
            isEditMode = true
            title = "Edit Catatan"
            
            // Isi data yang ada
            binding.editTextTitle.setText(intent.getStringExtra("NOTE_TITLE"))
            binding.editTextContent.setText(intent.getStringExtra("NOTE_CONTENT"))
        } else {
            // Mode tambah
            isEditMode = false
            title = "Tambah Catatan"
        }
    }
    
    private fun setupClickListeners() {
        binding.buttonSave.setOnClickListener {
            saveNote()
        }
        
        binding.buttonCancel.setOnClickListener {
            finish()
        }
    }
    
    private fun saveNote() {
        val title = binding.editTextTitle.text.toString().trim()
        val content = binding.editTextContent.text.toString().trim()
        
        // Validasi input
        if (title.isEmpty()) {
            binding.editTextTitle.error = "Judul tidak boleh kosong"
            return
        }
        
        if (content.isEmpty()) {
            binding.editTextContent.error = "Isi tidak boleh kosong"
            return
        }
        
        // Disable buttons untuk prevent double click
        binding.buttonSave.isEnabled = false
        binding.buttonCancel.isEnabled = false
        
        // Jalankan di background thread
        CoroutineScope(Dispatchers.IO).launch {
            try {
                if (isEditMode) {
                    // Update note yang ada
                    val note = Note(
                        id = noteId,
                        title = title,
                        content = content,
                        createdAt = System.currentTimeMillis()
                    )
                    database.noteDao().update(note)
                    
                    withContext(Dispatchers.Main) {
                        Toast.makeText(this@AddEditActivity, "Catatan diperbarui", Toast.LENGTH_SHORT).show()
                    }
                } else {
                    // Buat note baru
                    val note = Note(
                        title = title,
                        content = content,
                        createdAt = System.currentTimeMillis()
                    )
                    database.noteDao().insert(note)
                    
                    withContext(Dispatchers.Main) {
                        Toast.makeText(this@AddEditActivity, "Catatan ditambahkan", Toast.LENGTH_SHORT).show()
                    }
                }
                
                // Tutup activity
                finish()
                
            } catch (e: Exception) {
                withContext(Dispatchers.Main) {
                    binding.buttonSave.isEnabled = true
                    binding.buttonCancel.isEnabled = true
                    Toast.makeText(this@AddEditActivity, "Error: ${e.message}", Toast.LENGTH_SHORT).show()
                }
            }
        }
    }
}
```

### STEP 13: UPDATE ANDROID MANIFEST

Buka `AndroidManifest.xml`:

```xml
<?xml version="1.0" encoding="utf-8"?>
<manifest xmlns:android="http://schemas.android.com/apk/res/android"
    xmlns:tools="http://schemas.android.com/tools">

    <application
        android:allowBackup="true"
        android:dataExtractionRules="@xml/data_extraction_rules"
        android:fullBackupContent="@xml/backup_rules"
        android:icon="@mipmap/ic_launcher"
        android:label="@string/app_name"
        android:roundIcon="@mipmap/ic_launcher_round"
        android:supportsRtl="true"
        android:theme="@style/Theme.SimpleCRUD"
        tools:targetApi="31">
        
        <activity
            android:name=".MainActivity"
            android:exported="true">
            <intent-filter>
                <action android:name="android.intent.action.MAIN" />
                <category android:name="android.intent.category.LAUNCHER" />
            </intent-filter>
        </activity>
        
        <activity
            android:name=".AddEditActivity"
            android:exported="false"
            android:windowSoftInputMode="adjustResize" />
            
    </application>
</manifest>
```

---

## 🔍 TESTING APLIKASI

### Cara Testing:
1. **Build & Run**: Klik Run → Run 'app'
2. **Test Create**: Klik "Tambah Catatan" → Isi form → Klik "Simpan"
3. **Test Read**: Lihat daftar catatan di MainActivity
4. **Test Update**: Klik icon edit (pensil) → Ubah data → Klik "Simpan"
5. **Test Delete**: Klik icon delete (sampah) → Konfirmasi hapus

### Expected Results:
- ✅ Bisa menambah catatan baru
- ✅ Baca menampilkan daftar catatan
- ✅ Bisa mengedit catatan yang ada
- ✅ Bisa menghapus catatan
- ✅ Data tersimpan meskipun app di-close

---

## 🛠️ TROUBLESHOOTING

### Common Errors & Solutions:

#### 1. Gradle Sync Error
```bash
Solution:
- File → Invalidate Caches → Invalidate and Restart
- Pastikan internet connection stabil
- Cek versi dependencies yang compatible
```

#### 2. Room Database Error
```bash
Error: Cannot find setter for field
Solution: Pastikan entity menggunakan data class dengan var/val yang benar
```

#### 3. Coroutines Error
```bash
Error: Suspend function 'insert' should be called only from a coroutine
Solution: Pastikan operasi database dipanggil dari CoroutineScope
```

#### 4. View Binding Error
```bash
Error: Unresolved reference 'binding'
Solution: 
1. Pastikan viewBinding = true di build.gradle
2. Import binding yang benar
3. Clean & Rebuild project
```

---

## 📚 PENJELASAN KODE

### Konsep Penting:

#### 1. **Coroutines**
```kotlin
// Untuk operasi database (background thread)
CoroutineScope(Dispatchers.IO).launch {
    // Operasi database di sini
}

// Untuk update UI (main thread)
withContext(Dispatchers.Main) {
    // Update UI di sini
}
```

#### 2. **Room Database**
```kotlin
// Entity = Model data
@Entity(tableName = "notes")
data class Note(...)

// DAO = Interface untuk operasi database
@Dao
interface NoteDao { ... }

// Database = Class untuk koneksi database
@Database(...)
abstract class AppDatabase : RoomDatabase() { ... }
```

#### 3. **RecyclerView**
```kotlin
// Adapter untuk menampilkan data di RecyclerView
class NoteAdapter(...) : RecyclerView.Adapter<NoteAdapter.NoteViewHolder>() { ... }
```

---

## 🎯 TIPS UNTUK PEMULA

### 1. **Debugging**
- Gunakan `Log.d("TAG", "message")` untuk logging
- Gunakan breakpoints untuk step-by-step debugging
- Cek Logcat untuk error messages

### 2. **Best Practices**
- Selalu gunakan coroutines untuk operasi database
- Validasi input sebelum menyimpan ke database
- Handle errors dengan try-catch
- Gunakan appropriate dispatchers (IO untuk database, Main untuk UI)

### 3. **Code Organization**
- Pisahkan database logic dari UI logic
- Gunakan meaningful variable names
- Comment kode yang kompleks

---

### Yang Telah Dipelajari:
- ✅ Room Database setup
- ✅ CRUD operations (Create, Read, Update, Delete)
- ✅ Coroutines untuk asynchronous operations
- ✅ RecyclerView untuk menampilkan data
- ✅ Basic Android UI components

### Next Steps:
- Tambahkan fitur search
- Implementasi sorting
- Tambahkan kategori/tag
- Buat UI yang lebih menarik
