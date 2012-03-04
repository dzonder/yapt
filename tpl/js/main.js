$(document).ready(function(){
   prettyPrint();

   $('#btn-enc-plain').click(function(){
      $('#cg-passwd').hide();
   });

   $('#btn-enc-3des').click(function(){
      $('#cg-passwd').show();
   });
});
