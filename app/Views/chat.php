<div class="container">
  <div class="row">
    <div class="col-12 mt-5 pt-3 pb-3 bg-white from-wrapper">
      <div class="container">
        <h3>Chat</h3>
        <hr>
        <div class="row">
          <div class="col-12 col-sm-12 col-md-4 mb-3">
            <ul id="user-list" class="list-group">
            <?php foreach ($users as $user): ?>

              <a><li class="user" id="<?php echo $user['id'] ?>"><?= esc($user['username']) ?></li></a>

              <?php endforeach ?>
            </ul>
          </div>

          <div  id="Chatbot">
            <form method="post" >
                <div class="col-12 col-sm-12 col-md-8">
                  <div class="row">
                    <div class="col-12">
                      <div class="message-holder">
                          <div id="messages" class="row"></div>
                      </div>
                      <div class="form-group">
                      <textarea id="message-input" class="form-control" name="" rows="2"></textarea>
                      </div>
                  </div>
                    <div class="col-12">
                      <button id="send" type="button" class="btn float-right  btn-primary">Send</button>
                    </div>
                  </div>
                </div>
            </form>
          </div>
          
        </div>
      </div>
    </div>
  </div>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

<script>
$("#Chatbot").hide();
$(document).ready(function(){
  var idOfFrnd = "";
  $(".user").click(function(){
    idOfFrnd = $(this).attr('id');
    console.log(idOfFrnd);
      $("#Chatbot").show();
  });
  $("form").submit(function(){
    event.preventDefault();

    var formData = {
      name: $("#name").val(),
      email: $("#email").val(),
      superheroAlias: $("#superheroAlias").val(),
    };
    $.ajax({
      method: "POST",
      url: "<?php echo base_url().'sendmsg' ?>", 
      success: function(result){
        console.log(result);
    }});
  });
});
</script>

