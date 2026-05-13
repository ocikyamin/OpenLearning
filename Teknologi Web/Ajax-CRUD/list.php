<div class="card mt-4">
    <div class="card-body">
        <div class="alert mt-3 mb-4 bg-light">
<button onclick="openFormUser()" class="btn btn-primary btn-sm">New User</button>
        </div>
        <table class="table table-sm table-hover table-striped">
<thead>
    <tr>
        <th>No</th>
        <th>Email</th>
        <th>Fullname</th>
        <th>Action</th>
    </tr>
</thead>
<tbody>
    <?php
    $no =1;
    foreach ($users as $user) {?>
    <tr>
        <td><?=$no++?>.</td>
        <td><?=$user['email']?></td>
        <td><?=$user['name']?></td>
        <td>
            <a href="#" data-id="<?=$user['id']?>" class="btn btn-sm btn-info btn-edit">Edit</a>
            <a href="#" data-id="<?=$user['id']?>" class="btn btn-sm btn-danger btn-hapus">Delete</a>
        </td>
    </tr>
    <?php } ?>
</tbody>

</table>
    </div>
</div>
<div id="v-user-modal"></div>
<script>
    function openFormUser() {
        $.ajax({
            url: "<?=base_url('user/form')?>",
             data: {
                id : null,
                title : 'Tambah User',
                button : 'Save'
            },
            dataType: "json",
            success: function (res) {
                $('#v-user-modal').html(res.form)
                $('#formUserModal').modal('show')
            }
        });
    }

    // Buka Modal Edit data 
    $('.btn-edit').click(function (e) { 
        e.preventDefault();
        const id = $(this).data('id');
         $.ajax({
            url: "<?=base_url('user/form')?>",
            data: {
                id : id,
                title : 'Edit User',
                button : 'Update'
            },
            dataType: "json",
            success: function (res) {
                console.log(id)
                $('#v-user-modal').html(res.form)
                $('#formUserModal').modal('show')
            }
        });        
    });

$('.btn-hapus').click(function (e) { 
    e.preventDefault(); // Menghentikan aksi default tombol/link
  const id = $(this).data('id');
    // 1. Simpan hasil konfirmasi ke dalam variabel
    var yakin = confirm("Apakah Anda yakin ingin menghapus data ini?"); 

    // 2. Jika pengguna memilih "Ya" (true), jalankan AJAX
    if (yakin) {
        $.ajax({
            type: "post", // Ubah ke POST atau DELETE sesuai rute server Anda
            url: "<?=base_url('user/delete')?>", 
            data: { id: id}, // Data yang dikirim ke server
            dataType: "json",
            success: function (response) {
                // Beri tahu pengguna jika sukses
                alert("Data berhasil dihapus!");
                
                // Muat ulang halaman atau hapus baris tabel secara realtime
             loadUserData()
            },
            error: function (xhr, status, error) {
                alert("Gagal menghapus data: " + error);
            }
        });
    }
});



</script>