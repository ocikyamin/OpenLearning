<?= $this->extend('Layout') ?>
<?= $this->section('isi') ?>
<div id="content"></div>
<script>
$(document).ready(function () {
loadUserData()
});

function loadUserData() {
$.ajax({
url: "<?=base_url('user/list')?>",
data: "data",
dataType: "json",
success: function (res) {
  $('#content').html(res.user) 
}
});
}
</script>
<?= $this->endSection() ?>


