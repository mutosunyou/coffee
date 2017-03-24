//初期動作====================================================
$(function() {
  explain($('#ava').val());
  reloadTable();
   
  $('.toggle').toggles({
    click:true,
    drag:true,
    height:30,
    text:{
      on:'利用する',
      off:'利用しない'
    }
  });

  $('.toggle').on('toggle',function(e,active){
    console.log(active);
    if(active){
      set_next();
    }else{
      unset_next();
    }
    explain(active);
  });



  $('#withdrawal').click(function(){
    console.log($('#outer>option:selected').val());
    $.post(
      "helper/outer.php",
      {
        "name":$('#outer>option:selected').val()
      },
      function(dat){
        console.log(dat);
        location.href="./index.php";
      }
    ); 
  }
  );

  $('#admission').click(function(){
    console.log($('#inner>option:selected').val()); 
    $.post(
      "helper/inner.php",
      {
        "name":$('#inner>option:selected').val()
      },
      function(dat){
        console.log(dat);
        location.href="./index.php";
      }); 
  });

  $('#lister').on('click','.havepay',function(ev){
    console.log($(ev.target).attr('name'));
    $.post(
      "helper/pay.php",
      {
        "id":$(ev.target).attr('name')
      },
      function(dat){
        console.log(dat);
        location.reload();
      }
    );
  });

  $('#lister').on('click','.paycancel',function(ev){
    console.log($(ev.target).attr('name'));
    console.log($(ev.target).attr('user'));
    if(!confirm('キャンセルの場合、会員に確認メールを送信します。キャンセルしますか？')){
      return false;
    }else{
      $.post(
        "helper/cancelmail.php",
        {
          "userID":$(ev.target).attr('user')
        },
        function(dat){
          console.log(dat);
        }
      ); 
      $.post(
        "helper/paycancel.php",
        {
          "id":$(ev.target).attr('name')
        },
        function(dat){
          console.log(dat);
          location.reload();
        }
      ); 
    }
  });

  function reloadTable(){
    $.post(
      "lister.php",{
      },
      function(dat){
        $('#lister').html(dat);
      }
    );
  }

  function set_next(){
    $.post(
      "helper/change_next.php",{
        "userID":$('#userID').val(),
        "set":1
      },
      function(){}
    );
  }
  function unset_next(){
    $.post(
      "helper/change_next.php",{
        "userID":$('#userID').val(),
        "set":0
      },
      function(){}
    );
  }

  function explain(a){
      $('#exp').html('<h4 style="display:inline;float:left;">来月利用する?</h4>');
    
  }
});


