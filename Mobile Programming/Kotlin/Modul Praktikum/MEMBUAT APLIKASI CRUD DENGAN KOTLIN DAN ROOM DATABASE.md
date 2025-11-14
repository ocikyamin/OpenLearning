## 📋 PENDAHULUAN

### Apa itu CRUD?
CRUD adalah singkatan dari:
- **C**reate (Membuat data baru)
- **R**ead (Membaca/menampilkan data)  
- **U**pdate (Memperbarui data)
- **D**elete (Menghapus data)

### Apa itu Room Database?
Room adalah library Android yang menyediakan lapisan abstraksi atas SQLite untuk memudahkan operasi database dengan cara yang lebih aman dan efisien.

### Target Pembelajaran
Setelah mengikuti modul ini, mahasiswa dapat:
1. Membuat aplikasi Android dengan operasi CRUD lengkap
2. Menggunakan Room Database untuk penyimpanan data lokal
3. Menerapkan arsitektur MVVM (Model-View-ViewModel)
4. Menggunakan Coroutines untuk operasi asynchronous

---

## 🛠️ PERSIAPAN

### Software yang Dibutuhkan:
1. **Android Studio** (versi 2023.1.1+ atau Android Studio Hedgehog/Flamingo)
2. **Laptop/PC** dengan spesifikasi minimal:
   - Prosesor: Core i5 atau setara
   - RAM: 8 GB
   - Storage: 10 GB free space
3. **Android Device** (Physical device atau Emulator dengan API 21+)

### Penyesuaian untuk Android Studio 2023+:
- Gunakan **Kotlin DSL** untuk build.gradle (opsional)
- Update dependencies ke versi terbaru
- Gunakan **View Binding** sebagai pengganti findViewById

---

## 🚀 STEP-BY-STEP TUTORIAL

### STEP 1: MEMBUAT PROJECT BARU

1. Buka Android Studio
2. Klik **New Project**
3. Pilih **Empty Views Activity**
4. Konfigurasi project:
   - **Name**: CRUD Room App
   - **Package name**: com.example.crudroomapp
   - **Language**: Kotlin
   - **Minimum SDK**: API 21 (Android 5.0)
   - **Build configuration language**: Kotlin DSL (rekomendasi) atau Groovy
5. Klik **Finish**

### STEP 2: SETUP BUILD GRADLE

Buka file `build.gradle.kts` (Module :app) dan tambahkan:

```kotlin
plugins {
    id("com.android.application")
    id("org.jetbrains.kotlin.android")
    id("kotlin-kapt")
}

android {
    namespace = "com.example.crudroomapp"
    compileSdk = 34

    defaultConfig {
        applicationId = "com.example.crudroomapp"
        minSdk = 21
        targetSdk = 34
        versionCode = 1
        versionName = "1.0"

        testInstrumentationRunner = "androidx.test.runner.AndroidJUnitRunner"
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
    // Core Android Libraries
    implementation("androidx.core:core-ktx:1.12.0")
    implementation("androidx.appcompat:appcompat:1.6.1")
    implementation("com.google.android.material:material:1.11.0")
    implementation("androidx.constraintlayout:constraintlayout:2.1.4")
    
    // Room Database (versi terbaru)
    val roomVersion = "2.6.1"
    implementation("androidx.room:room-runtime:$roomVersion")
    implementation("androidx.room:room-ktx:$roomVersion")
    kapt("androidx.room:room-compiler:$roomVersion")
    
    // Coroutines
    implementation("org.jetbrains.kotlinx:kotlinx-coroutines-android:1.7.3")
    implementation("org.jetbrains.kotlinx:kotlinx-coroutines-core:1.7.3")
    
    // ViewModel & LiveData
    implementation("androidx.lifecycle:lifecycle-viewmodel-ktx:2.7.0")
    implementation("androidx.lifecycle:lifecycle-livedata-ktx:2.7.0")
    
    // Testing
    testImplementation("junit:junit:4.13.2")
    androidTestImplementation("androidx.test.ext:junit:1.1.5")
    androidTestImplementation("androidx.test.espresso:espresso-core:3.5.1")
}
```

### STEP 3: MEMBUAT PACKAGE STRUCTURE

1. Klik kanan pada package utama → **New** → **Package**
2. Buat package-package berikut:
   - `data` (untuk Entity, DAO, Database)
   - `ui` (untuk Activity, Adapter, ViewHolder)
   - `viewmodel` (untuk ViewModel classes)

### STEP 4: MEMBUAT ENTITY (MODEL DATA)

Buat package `data` → **New** → **Kotlin Class/File** → Beri nama `Note.kt`

```kotlin
package com.example.crudroomapp.data

import androidx.room.Entity
import androidx.room.PrimaryKey

@Entity(tableName = "notes")
data class Note(
    @PrimaryKey(autoGenerate = true)
    val id: Int = 0,
    val title: String,
    val content: String,
    val createdAt: Long = System.currentTimeMillis(),
    val updatedAt: Long = System.currentTimeMillis()
)
```

### STEP 5: MEMBUAT DAO (DATA ACCESS OBJECT)

Buat package `data` → **New** → **Kotlin Interface** → Beri nama `NoteDao.kt`

```kotlin
package com.example.crudroomapp.data

import androidx.room.*
import kotlinx.coroutines.flow.Flow

@Dao
interface NoteDao {
    @Insert
    suspend fun insertNote(note: Note): Long

    @Update
    suspend fun updateNote(note: Note): Int

    @Delete
    suspend fun deleteNote(note: Note): Int

    @Query("SELECT * FROM notes ORDER BY createdAt DESC")
    fun getAllNotes(): Flow<List<Note>>

    @Query("SELECT * FROM notes WHERE id = :noteId")
    suspend fun getNoteById(noteId: Int): Note?

    @Query("DELETE FROM notes WHERE id = :noteId")
    suspend fun deleteNoteById(noteId: Int): Int

    @Query("SELECT COUNT(*) FROM notes")
    fun getNoteCount(): Flow<Int>
}
```

### STEP 6: MEMBUAT DATABASE CLASS

Buat package `data` → **New** → **Kotlin Class** → Beri nama `AppDatabase.kt`

```kotlin
package com.example.crudroomapp.data

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
                    "note_database"
                )
                .fallbackToDestructiveMigration()
                .build()
                INSTANCE = instance
                instance
            }
        }
    }
}
```

### STEP 7: MEMBUAT REPOSITORY

Buat package `data` → **New** → **Kotlin Class** → Beri nama `NoteRepository.kt`

```kotlin
package com.example.crudroomapp.data

import kotlinx.coroutines.flow.Flow

class NoteRepository(private val noteDao: NoteDao) {
    
    val allNotes: Flow<List<Note>> = noteDao.getAllNotes()
    val noteCount: Flow<Int> = noteDao.getNoteCount()

    suspend fun insert(note: Note) = noteDao.insertNote(note)
    
    suspend fun update(note: Note) = noteDao.updateNote(note)
    
    suspend fun delete(note: Note) = noteDao.deleteNote(note)
    
    suspend fun getNoteById(id: Int): Note? = noteDao.getNoteById(id)
    
    suspend fun deleteById(id: Int) = noteDao.deleteNoteById(id)
}
```

### STEP 8: MEMBUAT VIEWMODEL

Buat package `viewmodel` → **New** → **Kotlin Class** → Beri nama `NoteViewModel.kt`

```kotlin
package com.example.crudroomapp.viewmodel

import android.app.Application
import androidx.lifecycle.*
import com.example.crudroomapp.data.AppDatabase
import com.example.crudroomapp.data.Note
import com.example.crudroomapp.data.NoteRepository
import kotlinx.coroutines.launch

class NoteViewModel(application: Application) : AndroidViewModel(application) {
    
    private val repository: NoteRepository
    
    val allNotes: LiveData<List<Note>>
    val noteCount: LiveData<Int>
    
    init {
        val noteDao = AppDatabase.getDatabase(application).noteDao()
        repository = NoteRepository(noteDao)
        allNotes = repository.allNotes.asLiveData()
        noteCount = repository.noteCount.asLiveData()
    }
    
    fun insert(note: Note) = viewModelScope.launch {
        repository.insert(note)
    }
    
    fun update(note: Note) = viewModelScope.launch {
        repository.update(note)
    }
    
    fun delete(note: Note) = viewModelScope.launch {
        repository.delete(note)
    }
    
    fun getNoteById(id: Int): LiveData<Note?> = liveData {
        emit(repository.getNoteById(id))
    }
    
    fun deleteById(id: Int) = viewModelScope.launch {
        repository.deleteById(id)
    }
}
```

### STEP 9: MEMBUAT LAYOUT UTAMA

Buka `res/layout/activity_main.xml` dan ganti isinya:

```xml
<?xml version="1.0" encoding="utf-8"?>
<androidx.constraintlayout.widget.ConstraintLayout 
    xmlns:android="http://schemas.android.com/apk/res/android"
    xmlns:app="http://schemas.android.com/apk/res-auto"
    xmlns:tools="http://schemas.android.com/tools"
    android:layout_width="match_parent"
    android:layout_height="match_parent"
    tools:context=".ui.MainActivity">

    <androidx.recyclerview.widget.RecyclerView
        android:id="@+id/recyclerViewNotes"
        android:layout_width="0dp"
        android:layout_height="0dp"
        android:padding="8dp"
        app:layout_constraintBottom_toTopOf="@+id/fabAdd"
        app:layout_constraintEnd_toEndOf="parent"
        app:layout_constraintStart_toStartOf="parent"
        app:layout_constraintTop_toTopOf="parent"
        tools:listitem="@layout/item_note" />

    <TextView
        android:id="@+id/textViewEmpty"
        android:layout_width="wrap_content"
        android:layout_height="wrap_content"
        android:text="Tidak ada catatan"
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

    <com.google.android.material.floatingactionbutton.FloatingActionButton
        android:id="@+id/fabAdd"
        android:layout_width="wrap_content"
        android:layout_height="wrap_content"
        android:layout_margin="16dp"
        android:contentDescription="Tambah Catatan"
        android:src="@android:drawable/ic_input_add"
        app:layout_constraintBottom_toBottomOf="parent"
        app:layout_constraintEnd_toEndOf="parent" />

</androidx.constraintlayout.widget.ConstraintLayout>
```

### STEP 10: MEMBUAT ITEM LAYOUT

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

    <androidx.constraintlayout.widget.ConstraintLayout
        android:layout_width="match_parent"
        android:layout_height="wrap_content"
        android:padding="16dp">

        <TextView
            android:id="@+id/textViewTitle"
            android:layout_width="0dp"
            android:layout_height="wrap_content"
            android:textStyle="bold"
            android:textSize="16sp"
            android:textColor="@android:color/black"
            app:layout_constraintEnd_toStartOf="@+id/buttonEdit"
            app:layout_constraintStart_toStartOf="parent"
            app:layout_constraintTop_toTopOf="parent"
            tools:text="Judul Catatan" />

        <TextView
            android:id="@+id/textViewContent"
            android:layout_width="0dp"
            android:layout_height="wrap_content"
            android:layout_marginTop="4dp"
            android:maxLines="2"
            android:ellipsize="end"
            app:layout_constraintEnd_toStartOf="@+id/buttonEdit"
            app:layout_constraintStart_toStartOf="parent"
            app:layout_constraintTop_toBottomOf="@+id/textViewTitle"
            tools:text="Isi catatan..." />

        <TextView
            android:id="@+id/textViewDate"
            android:layout_width="0dp"
            android:layout_height="wrap_content"
            android:layout_marginTop="4dp"
            android:textSize="12sp"
            android:textColor="@android:color/darker_gray"
            app:layout_constraintEnd_toStartOf="@+id/buttonEdit"
            app:layout_constraintStart_toStartOf="parent"
            app:layout_constraintTop_toBottomOf="@+id/textViewContent"
            tools:text="2024-01-01" />

        <ImageButton
            android:id="@+id/buttonEdit"
            android:layout_width="40dp"
            android:layout_height="40dp"
            android:background="?attr/selectableItemBackgroundBorderless"
            android:src="@android:drawable/ic_menu_edit"
            app:layout_constraintEnd_toStartOf="@+id/buttonDelete"
            app:layout_constraintTop_toTopOf="parent" />

        <ImageButton
            android:id="@+id/buttonDelete"
            android:layout_width="40dp"
            android:layout_height="40dp"
            android:background="?attr/selectableItemBackgroundBorderless"
            android:src="@android:drawable/ic_menu_delete"
            app:layout_constraintEnd_toEndOf="parent"
            app:layout_constraintTop_toTopOf="parent" />

    </androidx.constraintlayout.widget.ConstraintLayout>

</androidx.cardview.widget.CardView>
```

### STEP 11: MEMBUAT ADAPTER

Buat package `ui` → **New** → **Kotlin Class** → Beri nama `NoteAdapter.kt`

```kotlin
package com.example.crudroomapp.ui

import android.view.LayoutInflater
import android.view.ViewGroup
import androidx.recyclerview.widget.DiffUtil
import androidx.recyclerview.widget.ListAdapter
import androidx.recyclerview.widget.RecyclerView
import com.example.crudroomapp.data.Note
import com.example.crudroomapp.databinding.ItemNoteBinding
import java.text.SimpleDateFormat
import java.util.*

class NoteAdapter(
    private val onEditClick: (Note) -> Unit,
    private val onDeleteClick: (Note) -> Unit
) : ListAdapter<Note, NoteAdapter.NoteViewHolder>(NoteDiffCallback()) {

    override fun onCreateViewHolder(parent: ViewGroup, viewType: Int): NoteViewHolder {
        val binding = ItemNoteBinding.inflate(
            LayoutInflater.from(parent.context),
            parent,
            false
        )
        return NoteViewHolder(binding)
    }

    override fun onBindViewHolder(holder: NoteViewHolder, position: Int) {
        holder.bind(getItem(position))
    }

    inner class NoteViewHolder(private val binding: ItemNoteBinding) :
        RecyclerView.ViewHolder(binding.root) {

        fun bind(note: Note) {
            binding.textViewTitle.text = note.title
            binding.textViewContent.text = note.content
            
            // Format tanggal
            val dateFormat = SimpleDateFormat("dd/MM/yyyy", Locale.getDefault())
            binding.textViewDate.text = dateFormat.format(Date(note.createdAt))
            
            binding.buttonEdit.setOnClickListener { onEditClick(note) }
            binding.buttonDelete.setOnClickListener { onDeleteClick(note) }
        }
    }

    class NoteDiffCallback : DiffUtil.ItemCallback<Note>() {
        override fun areItemsTheSame(oldItem: Note, newItem: Note): Boolean {
            return oldItem.id == newItem.id
        }

        override fun areContentsTheSame(oldItem: Note, newItem: Note): Boolean {
            return oldItem == newItem
        }
    }
}
```

### STEP 12: MEMBUAT ACTIVITY TAMBAH/EDIT

Buat **New** → **Activity** → **Empty Activity** → Beri nama `AddEditActivity.kt`

Layout `res/layout/activity_add_edit.xml`:

```xml
<?xml version="1.0" encoding="utf-8"?>
<androidx.constraintlayout.widget.ConstraintLayout 
    xmlns:android="http://schemas.android.com/apk/res/android"
    xmlns:app="http://schemas.android.com/apk/res-auto"
    android:layout_width="match_parent"
    android:layout_height="match_parent"
    android:padding="16dp">

    <com.google.android.material.textfield.TextInputLayout
        android:id="@+id/textInputLayoutTitle"
        android:layout_width="0dp"
        android:layout_height="wrap_content"
        android:hint="Judul"
        app:layout_constraintEnd_toEndOf="parent"
        app:layout_constraintStart_toStartOf="parent"
        app:layout_constraintTop_toTopOf="parent">

        <com.google.android.material.textfield.TextInputEditText
            android:id="@+id/editTextTitle"
            android:layout_width="match_parent"
            android:layout_height="wrap_content"
            android:inputType="textCapSentences"
            android:maxLines="1" />

    </com.google.android.material.textfield.TextInputLayout>

    <com.google.android.material.textfield.TextInputLayout
        android:id="@+id/textInputLayoutContent"
        android:layout_width="0dp"
        android:layout_height="0dp"
        android:layout_marginTop="16dp"
        android:hint="Isi Catatan"
        app:layout_constraintBottom_toTopOf="@+id/buttonSave"
        app:layout_constraintEnd_toEndOf="parent"
        app:layout_constraintStart_toStartOf="parent"
        app:layout_constraintTop_toBottomOf="@+id/textInputLayoutTitle">

        <com.google.android.material.textfield.TextInputEditText
            android:id="@+id/editTextContent"
            android:layout_width="match_parent"
            android:layout_height="match_parent"
            android:gravity="top"
            android:inputType="textMultiLine|textCapSentences"
            android:minHeight="200dp"
            android:scrollbars="vertical" />

    </com.google.android.material.textfield.TextInputLayout>

    <Button
        android:id="@+id/buttonSave"
        android:layout_width="0dp"
        android:layout_height="wrap_content"
        android:layout_marginTop="16dp"
        android:text="Simpan"
        app:layout_constraintBottom_toBottomOf="parent"
        app:layout_constraintEnd_toEndOf="parent"
        app:layout_constraintStart_toStartOf="parent" />

</androidx.constraintlayout.widget.ConstraintLayout>
```

### STEP 13: IMPLEMENTASI MAIN ACTIVITY

Buka `MainActivity.kt` dan ganti isinya:

```kotlin
package com.example.crudroomapp.ui

import android.content.Intent
import android.os.Bundle
import android.widget.Toast
import androidx.activity.viewModels
import androidx.appcompat.app.AppCompatActivity
import androidx.recyclerview.widget.LinearLayoutManager
import com.example.crudroomapp.data.Note
import com.example.crudroomapp.databinding.ActivityMainBinding
import com.example.crudroomapp.viewmodel.NoteViewModel

class MainActivity : AppCompatActivity() {
    
    private lateinit var binding: ActivityMainBinding
    private val viewModel: NoteViewModel by viewModels()
    private lateinit var noteAdapter: NoteAdapter

    override fun onCreate(savedInstanceState: Bundle?) {
        super.onCreate(savedInstanceState)
        binding = ActivityMainBinding.inflate(layoutInflater)
        setContentView(binding.root)
        
        setupRecyclerView()
        setupObservers()
        setupClickListeners()
    }
    
    private fun setupRecyclerView() {
        noteAdapter = NoteAdapter(
            onEditClick = { note ->
                val intent = Intent(this, AddEditActivity::class.java).apply {
                    putExtra("NOTE_ID", note.id)
                    putExtra("NOTE_TITLE", note.title)
                    putExtra("NOTE_CONTENT", note.content)
                }
                startActivity(intent)
            },
            onDeleteClick = { note ->
                viewModel.delete(note)
                Toast.makeText(this, "Catatan dihapus", Toast.LENGTH_SHORT).show()
            }
        )
        
        binding.recyclerViewNotes.apply {
            layoutManager = LinearLayoutManager(this@MainActivity)
            adapter = noteAdapter
        }
    }
    
    private fun setupObservers() {
        viewModel.allNotes.observe(this) { notes ->
            noteAdapter.submitList(notes)
            
            // Tampilkan/sembunyikan empty state
            binding.textViewEmpty.visibility = if (notes.isEmpty()) View.VISIBLE else View.GONE
            binding.recyclerViewNotes.visibility = if (notes.isEmpty()) View.GONE else View.VISIBLE
        }
    }
    
    private fun setupClickListeners() {
        binding.fabAdd.setOnClickListener {
            startActivity(Intent(this, AddEditActivity::class.java))
        }
    }
}
```

### STEP 14: IMPLEMENTASI ADD/EDIT ACTIVITY

Buka `AddEditActivity.kt` dan ganti isinya:

```kotlin
package com.example.crudroomapp.ui

import android.os.Bundle
import android.widget.Toast
import androidx.activity.viewModels
import androidx.appcompat.app.AppCompatActivity
import com.example.crudroomapp.data.Note
import com.example.crudroomapp.databinding.ActivityAddEditBinding
import com.example.crudroomapp.viewmodel.NoteViewModel

class AddEditActivity : AppCompatActivity() {
    
    private lateinit var binding: ActivityAddEditBinding
    private val viewModel: NoteViewModel by viewModels()
    private var noteId: Int = -1

    override fun onCreate(savedInstanceState: Bundle?) {
        super.onCreate(savedInstanceState)
        binding = ActivityAddEditBinding.inflate(layoutInflater)
        setContentView(binding.root)
        
        setupToolbar()
        checkEditMode()
        setupClickListeners()
    }
    
    private fun setupToolbar() {
        setSupportActionBar(binding.toolbar)
        supportActionBar?.setDisplayHomeAsUpEnabled(true)
        supportActionBar?.setDisplayShowHomeEnabled(true)
    }
    
    private fun checkEditMode() {
        noteId = intent.getIntExtra("NOTE_ID", -1)
        
        if (noteId != -1) {
            // Edit mode
            supportActionBar?.title = "Edit Catatan"
            binding.editTextTitle.setText(intent.getStringExtra("NOTE_TITLE"))
            binding.editTextContent.setText(intent.getStringExtra("NOTE_CONTENT"))
        } else {
            // Add mode
            supportActionBar?.title = "Tambah Catatan"
        }
    }
    
    private fun setupClickListeners() {
        binding.buttonSave.setOnClickListener {
            saveNote()
        }
    }
    
    private fun saveNote() {
        val title = binding.editTextTitle.text.toString().trim()
        val content = binding.editTextContent.text.toString().trim()
        
        if (title.isEmpty()) {
            binding.editTextTitle.error = "Judul tidak boleh kosong"
            return
        }
        
        if (content.isEmpty()) {
            binding.editTextContent.error = "Isi catatan tidak boleh kosong"
            return
        }
        
        if (noteId != -1) {
            // Update existing note
            val updatedNote = Note(
                id = noteId,
                title = title,
                content = content,
                createdAt = System.currentTimeMillis(),
                updatedAt = System.currentTimeMillis()
            )
            viewModel.update(updatedNote)
            Toast.makeText(this, "Catatan diperbarui", Toast.LENGTH_SHORT).show()
        } else {
            // Create new note
            val newNote = Note(
                title = title,
                content = content,
                createdAt = System.currentTimeMillis(),
                updatedAt = System.currentTimeMillis()
            )
            viewModel.insert(newNote)
            Toast.makeText(this, "Catatan ditambahkan", Toast.LENGTH_SHORT).show()
        }
        
        finish()
    }
    
    override fun onSupportNavigateUp(): Boolean {
        onBackPressed()
        return true
    }
}
```

### STEP 15: UPDATE ANDROID MANIFEST

Buka `AndroidManifest.xml` dan pastikan terlihat seperti ini:

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
        android:theme="@style/Theme.CRUDRoomApp"
        tools:targetApi="31">
        
        <activity
            android:name=".ui.MainActivity"
            android:exported="true">
            <intent-filter>
                <action android:name="android.intent.action.MAIN" />
                <category android:name="android.intent.category.LAUNCHER" />
            </intent-filter>
        </activity>
        
        <activity
            android:name=".ui.AddEditActivity"
            android:exported="false"
            android:windowSoftInputMode="adjustResize" />
            
    </application>
</manifest>
```

---

## 🔍 TESTING & TROUBLESHOOTING

### Cara Testing:
1. **Build project**: Klik Build → Make Project
2. **Run app**: Klik Run → Run 'app'
3. **Test CRUD operations**:
   - **Create**: Klik FAB (+) untuk menambah catatan baru
   - **Read**: Lihat daftar catatan di RecyclerView
   - **Update**: Klik icon edit (pensil) pada item
   - **Delete**: Klik icon delete (sampah) pada item

### Common Issues & Solutions:

#### 1. Gradle Sync Error
```bash
// Coba solutions:
- File → Invalidate Caches → Invalidate and Restart
- Check internet connection
- Update Android Studio
- Use Gradle offline mode temporarily
```

#### 2. Room Database Error
```bash
// Common error: Cannot find setter for field
// Solution: Make sure all entity fields have proper getters/setters
// or use data class with val/var properties
```

#### 3. ViewModelProvider Error
```bash
// Make sure you have the correct dependencies:
implementation("androidx.lifecycle:lifecycle-viewmodel-ktx:2.7.0")
implementation("androidx.activity:activity-ktx:1.8.2")
```

#### 4. View Binding Error
```bash
// Enable view binding in build.gradle:
buildFeatures {
    viewBinding = true
}
```

---

## 📚 TIPS & BEST PRACTICES

### 1. Code Organization
- Gunakan package structure yang jelas
- Pisahkan logic antara UI, ViewModel, dan Repository
- Gunakan dependency injection (bisa mulai dengan manual DI)

### 2. Performance Optimization
- Gunakan DiffUtil di RecyclerView
- Implementasi pagination untuk data besar
- Gunakan Flow/LiveData untuk reactive programming

### 3. Error Handling
- Implementasi proper error handling dengan try-catch
- Tampilkan user-friendly error messages
- Log errors untuk debugging

### 4. Testing
- Tulis unit tests untuk ViewModel
- Tulis instrumented tests untuk UI
- Gunage mocking untuk dependencies

---

## 🎯 NEXT STEPS

### Fitur Tambahan yang Bisa Ditambahkan:
1. **Search functionality**: Implementasi search bar
2. **Sorting**: Sort by title, date, etc.
3. **Filtering**: Filter by category/tags
4. **Backup/Restore**: Export/Import data
5. **Cloud Sync**: Sync dengan Firebase atau backend
6. **Authentication**: User login/register
7. **Dark Mode**: Support tema gelap
8. **Animations**: Transisi dan micro-interactions

### Teknologi Lanjutan:
- **Hilt/Dagger**: Dependency injection
- **Paging 3**: Untuk pagination yang efisien
- **DataStore**: Untuk preferences
- **WorkManager**: Untuk background tasks

---

## 📖 SUMMARY

Dalam modul ini, kita telah mempelajari:

1. **Room Database Setup**: Konfigurasi database dengan Room
2. **CRUD Operations**: Implementasi Create, Read, Update, Delete
3. **MVVM Architecture**: Pemisahan concerns dengan Model-View-ViewModel
4. **Coroutines**: Asynchronous programming
5. **RecyclerView**: Efficient list display
6. **View Binding**: Type-safe view access
