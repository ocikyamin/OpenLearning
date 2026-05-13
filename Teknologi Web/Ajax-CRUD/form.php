<!-- Modal -->
<div class="modal fade" id="formUserModal" tabindex="-1" aria-labelledby="formUserModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="formUserModalLabel"><?=$title?></h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form id="user-form" action="">
        <input type="hidden" name="id" id="id" value="<?=$id?>">
        <input type="hidden" name="action" id="action" value="<?=$button?>">
      <div class="modal-body">
        <div class="form-group">
            <label for="email">Email</label>
            <input type="text" name="email" class="form-control" placholder="Masukkan email" value="<?=$user? $user['email']: null?>">
        </div>
        <div class="form-group">
            <label for="fullname">Fullname</label>
            <input type="text" name="name" class="form-control" placholder="Masukkan Nama User" value="<?=$user? $user['name']: null?>">
        </div>

     
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary"><?=$button?></button>
      </div>
    </div>
    </form>
  </div>
</div>
<script>
  $('#user-form').submit(function (e) { 
    e.preventDefault();
   let action = $('#action').val()
   $.ajax({
    type: "post",
    url: "<?=base_url('user/store')?>",
    data: $(this).serialize(),
    dataType: "json",
    success: function (response) {
      alert(response.message)
      $('#formUserModal').modal('hide')
      loadUserData()
      console.log(response)
    }
   });

    // console.log(action)
    // alert('okk')
    
  });

</script>