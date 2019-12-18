(function () {
  'use strict'

  var input = document.getElementById('input')
  document.getElementById('calculate').addEventListener(
    'click',
    function (event) {
      event.preventDefault()
      var val = input.value.replace(/[|]/g,'');
      val = val.split(',');
      var val1 = [];
      var key = $('.rdiaobx:checked').val();
      if(key == 0){
        key = $(".zidingyi").val();
      }
      if(!key){
        alert('输入密匙');
      }
      console.log(key)
      
      $.ajax({
        url: 'md5.php',
        data: {
          str: input.value,
          key: key
        },
        success: function(e){
          console.log(e)
          $("#result").val(e);
        },
        error: function(e){
          console.log('error')
        }
      })
    }
  )
  //input.value = 'MD5加密测试'
}())
