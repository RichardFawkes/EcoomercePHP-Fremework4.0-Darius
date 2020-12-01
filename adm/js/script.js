// Marca todas as checkbox relacionadas a coluna
$(document).ready(function() {
  $('i[data-name="checkAll"]').click(function(){ checkAll(this); });

  function checkAll(isso) {
    var checkGroup = $(isso).closest('div').find('input[type="checkbox"]');
    $(checkGroup).each(function(){ this.checked=true; });
  }
});