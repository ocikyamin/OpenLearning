# **Membuat Aplikasi CRUD Menggunakan Room Database SQLite**
Oleh **Abdul Yamin**, S.Pd., M.Kom

**Capaian Belajar :**

1. Mahasiswa dapat menjelaskan perintah SQL untuk CRUD database
2. Mahasiswa dapat menjelaskan komponen Room Database
3. Mahasiswa dapat membuat aplikasi android yang dapat mengambil data Room Database
   
**Alat dan Bahan :**

- Laptop atau PC dengan Spesifikasi Prosesor minimal Corei5 dan RAM 8 GB
- Android Studio
- Android Device
  
**Langkah - langkah Praktikum :**

1. **Buat Project baru di android studio**, dengan kriteria sebagai berikut :

![image.png](https://raw.githubusercontent.com/bucketio/img3/main/2025/11/16/1763277182324-f70bf204-38e9-436e-954b-28871d504db5.png '01 - Identitas Project')

2. **Melakukan Setup Pada Gradle** untuk menginstall library yang dibutuhkan. Buka **build.gradle (Module:app)** kemudian tambahkan kode berikut dan klik **Sync Now**

```
plugins {
    alias(libs.plugins.android.application)
    alias(libs.plugins.kotlin.android)
    id("kotlin-kapt") // Tambahkan ini
}

android {
    namespace = "com.ocikyamin.crudappusigroomdb"
    compileSdk = 36

    defaultConfig {
        applicationId = "com.ocikyamin.crudappusigroomdb"
        minSdk = 24
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

    buildFeatures {
        viewBinding = true // Tambahkan ini
    }

    compileOptions {
        sourceCompatibility = JavaVersion.VERSION_11
        targetCompatibility = JavaVersion.VERSION_11
    }

    kotlinOptions {
        jvmTarget = "11"
    }
}

dependencies {
    implementation(libs.androidx.core.ktx)
    implementation(libs.androidx.appcompat)
    implementation(libs.material)
    implementation(libs.androidx.activity)
    implementation(libs.androidx.constraintlayout)

    // Room Database
    implementation("androidx.room:room-runtime:2.8.3")
    implementation("androidx.room:room-ktx:2.8.3")
    kapt("androidx.room:room-compiler:2.8.3")
}

```
## **Persiapan Package**

3. Buat **package** baru dengan cara klik package utama lalu klik kanan, pilih new, kemudian pilih package

![image.png](https://raw.githubusercontent.com/bucketio/img0/main/2025/11/16/1763277730656-f0c3bce8-6f12-41c3-b666-a3e5d35c6917.png '02. Buat Package')
Kemudian isikan nama package dengan nama **“room”**

![image.png](https://raw.githubusercontent.com/bucketio/img17/main/2025/11/16/1763277804058-a3f061cb-d31e-4f72-80ab-ee95372edfdc.png '03. Nama Package')

4. Lalu kita buat model atau entity dari table dengan cara menambahkan **data class** bernama **note**. Caranya **klik kanan** pada **package** **room** lalu pilih **new**, kemudian pilih **Data Class** dan isikan namanya “**Note**”.
![image.png](https://raw.githubusercontent.com/bucketio/img0/main/2025/11/16/1763278124238-414f48d6-f48e-4ba5-9218-258dbb818cb6.png '04. Buat Note file')

Lalu tuliskan Data Class Note dengan kode berikut :
```kotlin
package com.ocikyamin.aplikasicrudroomdatabase.room

import androidx.room.Entity
import androidx.room.PrimaryKey

@Entity
data class Note(
    @PrimaryKey(autoGenerate = true)
    val id: Int,
    val title: String,
    val note: String,
)
```
**Penjelasan Kode**

- Baris 6 kita menambahkan notasi **@Entity** untuk menjadikan data class Note sebagai **entity**
- Baris 8 artinya kita menjadikan id sebagai **primary key**, kemudian nilai id akan di generate secara otomatis tanpa kita harus menuliskan perintah di insert. Jadi langsung otomatis nambah 1, tanpa kita menuliskan nilai id nya.
- Baris 9 sampai 11 menunjukan entity atau kolom yang digunakan pada tabel, ada kolom id, title, dan note

5. Tambahkan **Interface** dengan nama **NoteDao** pada package **room** untuk membuat **Data Access Object (DAO)**.

![image.png](https://raw.githubusercontent.com/bucketio/img19/main/2025/11/16/1763279810910-89f2e5e3-eaeb-45ca-9d71-6a0ba9a46514.png '05.Interface NoteDao ')

Kemudian isikan interface NoteDao dengan kode berikut :

```kotlin
package com.ocikyamin.aplikasicrudroomdatabase.room
import androidx.room.Dao
import androidx.room.Delete
import androidx.room.Insert
import androidx.room.Query
import androidx.room.Update

@Dao
interface NoteDao {
    @Insert
    suspend fun addNote(note: Note)
    @Update
    suspend fun updateNote(note: Note)
    @Delete
    suspend fun deleteNote(note: Note)

    @Query("SELECT * FROM note")
    suspend fun getNotes(): List<Note>

    @Query("SELECT * FROM note WHERE id = :note_id")
    suspend fun getNote(note_id: Int): Note?

}
```

**Penjelasan Kode:**

- Baris 3 kita menambahkan notasi @Dao untuk menjadikan interface NoteDao sebagai DAO
- Baris 6 kita tambahkan anotation @Insert untuk menambah data, lalu baris 7 kita buat fungsi addNote()
- Baris 9 kita tambahkan anotation @Update untuk mengubah data, lalu baris 10 kita buat fungsi updateNote()
- Baris 12 kita tambahkan anotation @Delete untuk menambah data, lalu baris 13 kita buat fungsi deleteNote()
- Baris 15 kita tambahan Query Select untuk menampilkan data dari tabel note, lalu - baris 16 kita buat fungsi getNotes() yang berisi data dari kelas Note
- Baris 18 kita tambahan Query Select dengan keyword id untuk menampilkan data dengan id tertentu, lalu baris 19 kita buat fungsi getNotes() dengan parameter note_id untuk mengambil id data

6. Selesai membuat entity dan DAO, terakhir kita buat instance untuk room database nya. Caranya klik kanan pada package r**oom -> pilih new -> Kotlin Class/File ->** Beri nama “**NoteDB**“.

   ![image.png](https://raw.githubusercontent.com/bucketio/img8/main/2025/11/16/1763280453530-6a6c6104-853b-4991-870c-28da0d9f463d.png 'image.png')

  
Isi class NoteDB dengan kode kotlin berikut :

```kotlin

import android.content.Context
import androidx.room.Database
import androidx.room.Room
import androidx.room.RoomDatabase

@Database(
    entities = [Note::class],
    version = 1,
    exportSchema = false
)
abstract class NoteDB : RoomDatabase() {

    abstract fun noteDao(): NoteDao

    companion object {
        @Volatile private var instance: NoteDB? = null
        private val LOCK = Any()

        operator fun invoke(context: Context) = instance ?: synchronized(LOCK) {
            instance ?: buildDatabase(context).also {
                instance = it
            }
        }

        private fun buildDatabase(context: Context) =
            Room.databaseBuilder(
                context.applicationContext,
                NoteDB::class.java,
                "note12345.db"
            ).build()
    }
}
```

**Penjelasan Kode :**

- Baris 1 – 4 untuk menjadikan data class Note digunakan sebagai database, versi database adalah 1
- Baris 6 membuat abstract class NoteDB akan mewarisi fungsi dari class RoomDatabase
- Baris 19 – 23 kita membuat fungsi buildDatabase untuk membuat database note12345.db sebagai tempat penyimpanan data

## **Desain Layout**
7. Buka **activity_main.xml**, kita akan mendesain layout untuk halaman utama. Tambahkan kode berikut untuk membuat tampilan halaman main.

```xml
<?xml version="1.0" encoding="utf-8"?>
<androidx.constraintlayout.widget.ConstraintLayout xmlns:android="http://schemas.android.com/apk/res/android"
    xmlns:app="http://schemas.android.com/apk/res-auto"
    xmlns:tools="http://schemas.android.com/tools"
    android:id="@+id/main"
    android:layout_width="match_parent"
    android:layout_height="match_parent"
    android:padding="17dp"
    tools:context=".MainActivity">

    <androidx.recyclerview.widget.RecyclerView
    android:id="@+id/list_note"
    android:layout_width="0dp"
    android:layout_height="0dp"
    app:layout_constraintBottom_toTopOf="@+id/button_create"
    app:layout_constraintLeft_toLeftOf="parent"
    app:layout_constraintRight_toRightOf="parent"
    app:layout_constraintTop_toTopOf="parent"
    tools:listitem="@layout/adapter_main"/>

    <Button
        android:id="@+id/button_create"
        android:layout_width="0dp"
        android:layout_height="wrap_content"
        android:text="Tulis Catatan"
        app:layout_constraintStart_toStartOf="parent"
        app:layout_constraintEnd_toEndOf="parent"
        app:layout_constraintBottom_toBottomOf="parent"
        android:layout_margin="10dp"/>

</androidx.constraintlayout.widget.ConstraintLayout>

```

Pada baris kode diatas kita menambahkan **RecyclerView** untuk **menampilkan data**, kemudian satu **Button** untuk menambah data baru. Apabila terjadi error pada attribute listitem, hal itu wajar karena kita belum menambahkan file **adapter_main.xml**. 
Buat file **adapter_main.xml** dengan cara klik kanan pada layout, kemudian klik new, pilih layout resource file, beri nama adapter_main. Pada file adapter_main.xml tambahkan kode berikut :

```xml
<androidx.constraintlayout.widget.ConstraintLayout
    xmlns:android="http://schemas.android.com/apk/res/android"
    android:layout_width="match_parent"
    android:layout_height="wrap_content"
    xmlns:tools="http://schemas.android.com/tools"
    xmlns:app="http://schemas.android.com/apk/res-auto">

    <TextView
        android:id="@+id/textTitle"
        android:layout_width="0dp"
        android:layout_height="wrap_content"
        tools:text="Nanti kita cerita hari ini"
        app:layout_constraintTop_toTopOf="parent"
        app:layout_constraintBottom_toBottomOf="parent"
        app:layout_constraintStart_toStartOf="parent"
        app:layout_constraintEnd_toStartOf="@+id/iconEdit"/>

    <ImageView
        android:id="@+id/iconEdit"
        android:layout_width="wrap_content"
        android:layout_height="wrap_content"
        android:src="@drawable/ic_edit"
        android:padding="10dp"
        app:layout_constraintTop_toTopOf="parent"
        app:layout_constraintEnd_toStartOf="@+id/iconDelete"/>

    <ImageView
        android:id="@+id/iconDelete"
        android:layout_width="wrap_content"
        android:layout_height="wrap_content"
        android:src="@drawable/ic_delete"
        android:padding="10dp"
        app:layout_constraintTop_toTopOf="parent"
        app:layout_constraintEnd_toEndOf="parent"/>

</androidx.constraintlayout.widget.ConstraintLayout>


```
Akan terjadi **error** pada attribute **src**, hal ini dikarenakan kita belum menambah **icon edit dan icon delete**. Untuk menambah icon silahkan klik kanan pada **Drawable -> Pilih New -> Pilih Vector Asset**. Kemudian ketikan ditombol pencarian keyword “**edit**”. Pilih icon edit bergambar pensil. Lakukan hal yang sama untuk membuat **icon delete**. Cari di tombol pencarian dengan keyword “**delete**”

8. **Buat Activity baru** dengan cara klik kanan pada package utama kemudian **klik new -> Activity -> Empty Activity**. Kemudian beri nama **EditActivity**. Pada file **activity_edit.xml** silahkan tambahkan kode berikut ini

```xml

<?xml version="1.0" encoding="utf-8"?>
<androidx.constraintlayout.widget.ConstraintLayout xmlns:android="http://schemas.android.com/apk/res/android"
    xmlns:app="http://schemas.android.com/apk/res-auto"
    xmlns:tools="http://schemas.android.com/tools"
    android:id="@+id/main"
    android:layout_width="match_parent"
    android:layout_height="match_parent"
    android:padding="17dp"
    tools:context=".EditActivity">
    <EditText
        android:id="@+id/edit_title"
        android:layout_width="0dp"
        android:layout_height="wrap_content"
        android:hint="Judul"
        app:layout_constraintStart_toStartOf="parent"
        app:layout_constraintEnd_toEndOf="parent"
        app:layout_constraintTop_toTopOf="parent"
        android:background="@drawable/edittextstyle"/>

    <EditText
        android:id="@+id/edit_note"
        android:layout_width="0dp"
        android:layout_height="wrap_content"
        android:hint="Tulis Catatan"
        android:minLines="3"
        app:layout_constraintStart_toStartOf="parent"
        app:layout_constraintEnd_toEndOf="parent"
        app:layout_constraintTop_toBottomOf="@+id/edit_title"
        android:layout_marginTop="10dp"
        android:gravity="top"
        android:background="@drawable/edittextstyle"/>

    <Button
        android:id="@+id/button_save"
        android:layout_width="0dp"
        android:layout_height="wrap_content"
        android:text="SAVE"
        app:layout_constraintStart_toStartOf="parent"
        app:layout_constraintEnd_toEndOf="parent"
        app:layout_constraintTop_toBottomOf="@+id/edit_note"
        android:layout_marginTop="20dp"/>

    <Button
        android:id="@+id/button_update"
        android:layout_width="0dp"
        android:layout_height="wrap_content"
        android:text="UPDATE"
        app:layout_constraintStart_toStartOf="parent"
        app:layout_constraintEnd_toEndOf="parent"
        app:layout_constraintTop_toBottomOf="@+id/button_save"
        android:layout_marginTop="10dp"/>

</androidx.constraintlayout.widget.ConstraintLayout>

```
Apabila terjadi error pada attribute background, lakukan penambahan file **edittextstyle**. Caranya klik pada pada direktori **drawable -> klik New -> Pilih Drawable Resource File**. Kemudian isikan File name dengan edittextstyle dan isikan dengan kode berikut.

```xml
<?xml version="1.0" encoding="utf-8"?>
<shape xmlns:android="http://schemas.android.com/apk/res/android">
    <corners android:radius="10dp" />
    <padding android:bottom="15dp"
        android:right="15dp"
        android:left="15dp"
        android:top="15dp"/>
    <solid android:color="#f3f6f4"/>
</shape>

```

Sehingga tampilan dari **activity_edit.xml** menjadi sebagai berikut :

![image.png](https://raw.githubusercontent.com/bucketio/img19/main/2025/11/16/1763281741703-3e9ed1ad-6644-47c2-a9fd-caa5d2810783.png 'image.png')
9. Sebelum menambahkan kode di **EditActivity**, kita perlu menambahkan dulu sebuah class yang menampung id dari tiap data. Buat class baru pada package **room** dengan cara klik kanan pada package room, pilih new, pilih **Kotlin Class/File**, beri nama **Constant**.

![image.png](https://raw.githubusercontent.com/bucketio/img0/main/2025/11/16/1763303757790-7aef24e7-7406-4ecf-8f01-c34f26b291e4.png 'image.png')

Kemudian isikan class Contant dengan kode kotlin berikut :
```kotlin
class Constant {
    companion object {
        const val TYPE_READ = 0
        const val TYPE_CREATE = 1
        const val TYPE_UPDATE = 2
    }
}
```

**Penjelasan Kode :**

- Baris 2 digunakan untuk menyimpan id 0 ke dalam TYPE_READ untuk membaca data
- Baris 3 digunakan untuk menyimpan id 1 ke dalam TYPE_CREATE untuk menambah data
- Baris 4 digunakan untuk menyimpan id 2 ke dalam TYPE_UPDATE untuk mengupdate data

10. Setelah class Contant berhasil dibuat, selanjutnya kita isi file **EditActivity** dengan kode kotlin berikut :

```kotlin


import android.os.Bundle
import android.view.View
import androidx.appcompat.app.AppCompatActivity
import androidx.lifecycle.lifecycleScope
import com.ocikyamin.crudappusigroomdb.databinding.ActivityEditBinding
import com.ocikyamin.crudappusigroomdb.room.Constant
import com.ocikyamin.crudappusigroomdb.room.Note
import com.ocikyamin.crudappusigroomdb.room.NoteDB
import kotlinx.coroutines.Dispatchers
import kotlinx.coroutines.launch
import kotlinx.coroutines.withContext

class EditActivity : AppCompatActivity() {

    private val db by lazy { NoteDB(this) }
    private var noteId: Int = 0

    private lateinit var binding: ActivityEditBinding

    override fun onCreate(savedInstanceState: Bundle?) {
        super.onCreate(savedInstanceState)
        binding = ActivityEditBinding.inflate(layoutInflater)
        setContentView(binding.root)

        setupView()
        setupListener()
    }

    private fun setupView() {
        supportActionBar?.setDisplayHomeAsUpEnabled(true)

        val intentType = intent.getIntExtra("intent_type", 0)

        when (intentType) {
            Constant.TYPE_CREATE -> {
                binding.buttonUpdate.visibility = View.GONE
            }
            Constant.TYPE_READ -> {
                binding.buttonSave.visibility = View.GONE
                binding.buttonUpdate.visibility = View.GONE
                getNote()
            }
            Constant.TYPE_UPDATE -> {
                binding.buttonSave.visibility = View.GONE
                getNote()
            }
        }
    }

    private fun setupListener() {

        // INSERT
        binding.buttonSave.setOnClickListener {
            val title = binding.editTitle.text.toString()
            val note = binding.editNote.text.toString()

            lifecycleScope.launch(Dispatchers.IO) {
                db.noteDao().addNote(
                    Note(0, title, note)
                )
                finish()
            }
        }

        // UPDATE
        binding.buttonUpdate.setOnClickListener {
            val title = binding.editTitle.text.toString()
            val note = binding.editNote.text.toString()

            lifecycleScope.launch(Dispatchers.IO) {
                db.noteDao().updateNote(
                    Note(noteId, title, note)
                )
                finish()
            }
        }
    }

    private fun getNote() {
        noteId = intent.getIntExtra("intent_id", 0)

        lifecycleScope.launch(Dispatchers.IO) {
            val note = db.noteDao().getNote(noteId)

            note?.let {
                withContext(Dispatchers.Main) {
                    binding.editTitle.setText(it.title)
                    binding.editNote.setText(it.note)
                }
            }
        }
    }

    // onBackPressed diganti dengan cara modern
    override fun onSupportNavigateUp(): Boolean {
        onBackPressedDispatcher.onBackPressed()
        return true
    }
}


```
**Penjelasan Kode :**
- Baris 3 kita membuat variable db yang berisi instance dari class **NoteDB**. Fungsi Lazy digunakan untuk mendeklarasikan nilai properti saat pertama kali dijalankan
- Baris 4 memberikan nilai 0 pada variable noteId. Jadi untuk melakukan edit data, identifiernya id 0
- Baris 16 – 33 membuat fungsi setupView(), didalamnya terdapat perintah untuk menambahkan button navigation up. Kemudian juga terdapat tipe intent seperti TYPE_CREATE untuk menulis data baru (button yang ditampilkan button save). Ada pula TYPE_UPDATE untuk mengedit data (button yang ditampilkan button update). Terakhir terdapat TYPE_READ untuk membaca data (button yang ditampilkan adalah button save dan update)
- Baris 35 – 53 terdapat fungsi setupListener() yang berfungsi untuk memberikan aksi ketika button di klik. Jika button save di klik maka fungsi addNote() dipanggil dan terjadi penambahan data. Namun jika button edit yang diklik maka fungsi updateNote() aktif dan akan mengupdate data yang telah diubah.
- Baris 55 – 62 terdapat fungsi getNote() yang berfungsi untuk mengabil data yang kita pilih dan menampilkannya ke EditText.
Baris 64 – 67 merupakan fungsi untuk kembali ke halaman sebelumnya

11. Untuk dapat menampilkan data ke **RecyclerView**, maka kita perlu menambahkan **Adapter**. Sekarang mari kita buat Class **Adapater** dengan cara **klik kanan pada package utama, pilih new, pilih Kotlin Class/File**, beri nama **NoteAdapter**. Isi class **NoteAdapter** dengan kode kotlin berikut :

```kotlin


import android.view.LayoutInflater
import android.view.ViewGroup
import androidx.recyclerview.widget.RecyclerView
import com.ocikyamin.crudappusigroomdb.databinding.AdapterMainBinding
import com.ocikyamin.crudappusigroomdb.room.Note

class NoteAdapter(
    private var notes: ArrayList<Note>,
    private val listener: OnAdapterListener
) : RecyclerView.Adapter<NoteAdapter.NoteViewHolder>() {

    inner class NoteViewHolder(val binding: AdapterMainBinding)
        : RecyclerView.ViewHolder(binding.root)

    override fun onCreateViewHolder(parent: ViewGroup, viewType: Int): NoteViewHolder {
        val binding = AdapterMainBinding.inflate(
            LayoutInflater.from(parent.context),
            parent,
            false
        )
        return NoteViewHolder(binding)
    }

    override fun getItemCount(): Int = notes.size

    override fun onBindViewHolder(holder: NoteViewHolder, position: Int) {
        val note = notes[position]

        holder.binding.textTitle.text = note.title

        holder.binding.textTitle.setOnClickListener {
            listener.onRead(note)
        }

        holder.binding.iconEdit.setOnClickListener {
            listener.onUpdate(note)
        }

        holder.binding.iconDelete.setOnClickListener {
            listener.onDelete(note)
        }
    }

    fun setData(newData: List<Note>) {
        notes.clear()
        notes.addAll(newData)
        notifyDataSetChanged()
    }

    interface OnAdapterListener {
        fun onRead(note: Note)
        fun onUpdate(note: Note)
        fun onDelete(note: Note)
    }
}

```
Terakhir tambahkan kode ke MainActivity seperti berikut :
```kotlin

import android.content.Intent
import android.os.Bundle
import android.util.Log
import androidx.appcompat.app.AlertDialog
import androidx.appcompat.app.AppCompatActivity
import androidx.recyclerview.widget.LinearLayoutManager
import com.ocikyamin.crudappusigroomdb.databinding.ActivityMainBinding
import com.ocikyamin.crudappusigroomdb.room.Constant
import com.ocikyamin.crudappusigroomdb.room.Note
import com.ocikyamin.crudappusigroomdb.room.NoteDB
import kotlinx.coroutines.CoroutineScope
import kotlinx.coroutines.Dispatchers
import kotlinx.coroutines.launch
import kotlinx.coroutines.withContext


class MainActivity : AppCompatActivity() {
    private lateinit var binding : ActivityMainBinding
    lateinit var noteAdapter: NoteAdapter

    val db by lazy { NoteDB(this) }


    override fun onCreate(savedInstanceState: Bundle?) {
        super.onCreate(savedInstanceState)
        binding = ActivityMainBinding.inflate(layoutInflater)
        setContentView(binding.root)

        setupListener()
        setupRecyclerView()

    }
    override fun onStart() {
        super.onStart()
        loadNote()
    }

    fun loadNote(){
        CoroutineScope(Dispatchers.IO).launch {
            val notes = db.noteDao().getNotes()
            Log.d("MainActivity", "dbResponse: $notes")
            withContext(Dispatchers.Main){
                noteAdapter.setData(notes)
            }
        }
    }

    private fun setupListener() {
        binding.buttonCreate.setOnClickListener {
            //startActivity(Intent(this, EditActivity::class.java))
            intentEdit(0, Constant.TYPE_CREATE)
        }
    }

    fun intentEdit(noteId: Int, intentType: Int){
        startActivity(
            Intent(applicationContext, EditActivity::class.java)
                .putExtra("intent_id", noteId)
                .putExtra("intent_type", intentType)
        )
    }

    private fun setupRecyclerView() {
        noteAdapter = NoteAdapter(arrayListOf(), object : NoteAdapter.OnAdapterListener{
            override fun onRead(note: Note) {
                intentEdit(note.id, Constant.TYPE_READ)
            }

            override fun onUpdate(note: Note) {
                intentEdit(note.id, Constant.TYPE_UPDATE)
            }

            override fun onDelete(note: Note) {
                deleteDialog(note)
            }

        })
        binding.listNote.apply {
            layoutManager = LinearLayoutManager(applicationContext)
            adapter = noteAdapter
        }
    }

    private fun deleteDialog(note: Note){
        val alertDialog = AlertDialog.Builder(this)
        alertDialog.apply {
            setTitle("Konfirmasi")
            setMessage("Yakin Hapus ${note.title}?" )
            setNegativeButton("Batal") { dialogInterface, i ->
                dialogInterface.dismiss()
            }
            setPositiveButton("Hapus") { dialogInterface, i ->
                dialogInterface.dismiss()
                CoroutineScope(Dispatchers.IO).launch {
                    db.noteDao().deleteNote(note)
                    loadNote()
                }
            }
        }
        alertDialog.show()
    }


}
```
13. Apabila tidak ada yang error, silahkan running program dan anda akan mendapatkan hasil sebagai berikut:
![Screenshot_20251116_220833.png](https://raw.githubusercontent.com/bucketio/img18/main/2025/11/16/1763305900594-046557fa-d09f-4d2b-b2c1-cebdd32fef96.png 'Screenshot_20251116_220833.png')
![Screenshot_20251116_220850.png](https://raw.githubusercontent.com/bucketio/img15/main/2025/11/16/1763305902700-5defc8fe-6e13-4ccf-86b4-55f984e8b5c6.png 'Screenshot_20251116_220850.png')
![Screenshot_20251116_220902.png](https://raw.githubusercontent.com/bucketio/img1/main/2025/11/16/1763305904141-4f2a8150-525f-41ad-94c0-6aba1eaa46cd.png 'Screenshot_20251116_220902.png')

