function displayMessage(e, n, i, o) {
    $.alert(e, {
        title: n,
        type: i,
        closeTime: 1e3 * o
    })
}
function verifyContribui(e) {
    let n = getCustomer();
    if(n){
    	refreshDadosUsuario(n.id);
    }
    n ? n.contribui ? ($("#" + e).show(),
    $("#" + e + "-nc").hide()) : ($("#" + e).hide(),
    $("#" + e + "-nc").show()) : $("#joinSystem").show()
}
function register(e) {
    let n = "N\xe3o Logado"
      , i = getCustomer();
    i && (n = i.nome),
    $.ajax({
        url: "ajax-requisicao.php",
        type: "get",
        dataType: "json",
        data: {
            url: e,
            user: n
        }
    }).done(function(e) {}).fail(function(e, n, i) {})
}
!function(e) {
    e(function() {
        e(".dinheiro").mask("#.##0,00", {
            reverse: !0
        });
        var n = function(e) {
            return 11 === e.replace(/\D/g, "").length ? "(00) 00000-0000" : "(00) 0000-00009"
        };
        e(".telefone").mask(n, {
            onKeyPress: function(e, i, o, t) {
                o.mask(n.apply({}, arguments), t)
            }
        })
    })
}(jQuery);
