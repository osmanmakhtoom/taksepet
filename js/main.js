$(document).ready(function() {

    let sirket_turu = false;

    $('#sirket').on('change', function() {
        if (this.value === '2') {
            sirket_turu = true;
        }
        else{
            sirket_turu = false;
        }
    });

    $('#btn-register').click(function() {
        $('#ana-sayfa').addClass('d-none');
        $('#basvuru-formu').removeClass('d-none');
    })

    $('#tab-temel').focus(function(e){
        
        e.preventDefault();

        $('#tab-parola').removeClass('active-bg');
        $('#tab-sirket').removeClass('active-bg');
        $('#tab-entegrasyon').removeClass('active-bg');

        $('#parola-form').addClass('d-none');
        $('#sirket-form').addClass('d-none');
        $('#entegrasyon-form').addClass('d-none');

        $('#temel-form').removeClass('d-none');
        $(this).addClass('active-bg');
    })
    $('#tab-parola').focus(function(e){
        
        e.preventDefault();

        $('#tab-temel').removeClass('active-bg');
        $('#tab-sirket').removeClass('active-bg');
        $('#tab-entegrasyon').removeClass('active-bg');

        $('#temel-form').addClass('d-none');
        $('#sirket-form').addClass('d-none');
        $('#entegrasyon-form').addClass('d-none');

        $('#parola-form').removeClass('d-none');
        $(this).addClass('active-bg');
    })
    $('#tab-sirket').focus(function(e){
        
        e.preventDefault();

        if (!sirket_turu) {
            $('#div-gazete').addClass('d-none');
            $('#div-belge').addClass('d-none');
        }
        else{
            $('#div-gazete').removeClass('d-none');
            $('#div-belge').removeClass('d-none');
        }

        $('#tab-temel').removeClass('active-bg');
        $('#tab-parola').removeClass('active-bg');
        $('#tab-entegrasyon').removeClass('active-bg');

        $('#parola-form').addClass('d-none');
        $('#temel-form').addClass('d-none');
        $('#entegrasyon-form').addClass('d-none');

        $('#sirket-form').removeClass('d-none');
        $(this).addClass('active-bg');
    })
    $('#tab-entegrasyon').focus(function(e){
        
        e.preventDefault();

        $('#tab-temel').removeClass('active-bg');
        $('#tab-sirket').removeClass('active-bg');
        $('#tab-parola').removeClass('active-bg');

        $('#parola-form').addClass('d-none');
        $('#sirket-form').addClass('d-none');
        $('#temel-form').addClass('d-none');

        $('#entegrasyon-form').removeClass('d-none');
        $(this).addClass('active-bg');
    })


    $("#temel-form").submit(function(e){
        e.preventDefault();

        let formData = new FormData();

        let full_name = $("#full_name").val();
        let phone = $("#phone").val();
        let email = $("#email").val();
        let sirket = $("#sirket option:selected").text();
        let tcvkn = $("#tcvkn").val();
        let il = $("#il option:selected").text();
        let ilce = $('#ilce').val();
        let kategori = $('#kategori').val();

        let kimlikOn = document.getElementById("kimlikOn");
        let kimlikArka = document.getElementById("kimlikArka");
        let ikametgah = document.getElementById("ikametgah");

        formData.append('full_name', full_name);
        formData.append('phone', phone);
        formData.append('email', email);
        formData.append('sirket', sirket);
        formData.append('tcvkn', tcvkn);
        formData.append('il', il);
        formData.append('ilce', ilce);
        formData.append('kategori', kategori);

        if ('files' in kimlikOn) {
            if (kimlikOn.files.length > 0) {
                formData.append('kimlikOn', kimlikOn.files[0]);
            }
        }

        
        if ('files' in kimlikArka) {
            if (kimlikArka.files.length > 0) {
                formData.append('kimlikArka', kimlikArka.files[0]);
            }
        }

        
        if ('files' in ikametgah) {
            if (ikametgah.files.length > 0) {
                formData.append('ikametgah', ikametgah.files[0]);
            }
        }

        formData.append('page', 1);

        $.ajax({
            url: "process.php",
            type: "POST",
            data: formData,
            processData: false,
            contentType: false,
            success: function(s){
                if (1 == s) {
                    $("#tab-temel").addClass('disabled');
                    $("#tab-entegrasyon").addClass('disabled');
                    $('#tab-sirket').addClass('disabled');
                    $('#tab-parola').removeClass('disabled');
                    $('#tab-parola').focus();
                }
            },
            error:function(e,t,a){
                console.error(e.responseText)
            }
        })

    })


    $("#parola-form").submit(function(e){
        e.preventDefault();

        let formData = new FormData();

        let parola = $("#parola").val();
        let parola2 = $("#parola2").val();

        if (parola !== parola2) {

            alert("Parola ve tekrari ayni degil lutfen dikkat edin!")
            return;

        }

        formData.append('parola', parola);
        formData.append('parola2', parola2);

        formData.append('page', 2);

        $.ajax({
            url: "process.php",
            type: "POST",
            data: formData,
            processData: false,
            contentType: false,
            success: function(s){
                if (1 == s) {
                    $("#tab-temel").addClass('disabled');
                    $("#tab-entegrasyon").addClass('disabled');
                    $('#tab-parola').addClass('disabled');
                    $('#tab-sirket').removeClass('disabled');
                    $('#tab-sirket').focus();
                }
            },
            error:function(e,t,a){
                console.error(e.responseText)
            }
        })

    })


    $("#sirket-form").submit(function(e){
        e.preventDefault();

        let formData = new FormData();

        let magazaAdi = $("#magazaAdi").val();
        let kep = $("#kep").val();
        let mersis = $("#mersis").val();
        let fatura = $("#fatura option:selected").text();
        let iban = $("#iban").val();

        let vergiLevhe = document.getElementById("vergiLevhe");
        let imza = document.getElementById("imza");
        let gazete = document.getElementById("gazete");
        let belge = document.getElementById("belge");

        formData.append('magazaAdi', magazaAdi);
        formData.append('kep', kep);
        formData.append('mersis', mersis);
        formData.append('fatura', fatura);
        formData.append('iban', iban);
        
        if ('files' in vergiLevhe) {
            if (vergiLevhe.files.length > 0) {
                formData.append('vergiLevhe', vergiLevhe.files[0]);
            }
        }

        
        if ('files' in imza) {
            if (imza.files.length > 0) {
                formData.append('imza', imza.files[0]);
            }
        }

        
        if ('files' in gazete) {
            if (gazete.files.length > 0) {
                formData.append('gazete', gazete.files[0]);
            }
        }

        if ('files' in belge) {
            if (belge.files.length > 0) {
                formData.append('belge', belge.files[0]);
            }
        }

        formData.append('page', 3);

        $.ajax({
            url: "process.php",
            type: "POST",
            data: formData,
            processData: false,
            contentType: false,
            success: function(s){
                if (1 == s) {
                    $("#tab-temel").addClass('disabled');
                    $('#tab-sirket').addClass('disabled');
                    $('#tab-parola').addClass('disabled');
                    $("#tab-entegrasyon").removeClass('disabled');
                    $('#tab-entegrasyon').focus();
                }
            },
            error:function(e,t,a){
                console.error(e.responseText)
            }
        })

    })

    $("#entegrasyon-form").submit(function(e){
        e.preventDefault();

        let formData = new FormData();

        let kargoFirma = $("#kargoFirma").val();
        let teslimSure = $("#teslimSure").val();
        let entegrasyonModel = $("#entegrasyonModel").val();
        let faturaAdres = $("#faturaAdres").val();
        let sirketAdres = $("#sirketAdres").val();
        let depoAdres = $("#depoAdres").val();
        let iadeAdres = $("#iadeAdres").val();
        let finansName = $("#finansName").val();
        let finansPhone = $("#finansPhone").val();
        let finansEmail = $("#finansEmail").val();
        let musteriName = $("#musteriName").val();
        let musteriPhone = $("#musteriPhone").val();
        let musteriEmail = $("#musteriEmail").val();
        let operasyonName = $("#operasyonName").val();
        let operasyonPhone = $("#operasyonPhone").val();
        let operasyonEmail = $("#operasyonEmail").val();

        formData.append('kargoFirma', kargoFirma);
        formData.append('teslimSure', teslimSure);
        formData.append('entegrasyonModel', entegrasyonModel);
        formData.append('faturaAdres', faturaAdres);
        formData.append('sirketAdres', sirketAdres);
        formData.append('depoAdres', depoAdres);
        formData.append('iadeAdres', iadeAdres);
        formData.append('finansName', finansName);
        formData.append('finansPhone', finansPhone);
        formData.append('finansEmail', finansEmail);
        formData.append('musteriName', musteriName);
        formData.append('musteriPhone', musteriPhone);
        formData.append('musteriEmail', musteriEmail);
        formData.append('operasyonName', operasyonName);
        formData.append('operasyonPhone', operasyonPhone);
        formData.append('operasyonEmail', operasyonEmail);

        formData.append('page', 4);

        $.ajax({
            url: "process.php",
            type: "POST",
            data: formData,
            processData: false,
            contentType: false,
            success: function(s){
                if (1 == s) {
                    $("#tab-temel").addClass('disabled');
                    $('#tab-sirket').addClass('disabled');
                    $('#tab-parola').addClass('disabled');
                    $("#tab-entegrasyon").addClass('disabled');
                    alert(s);
                    window.location.reload();
                }
            },
            error:function(e,t,a){
                console.error(e.responseText)
            }
        })

    })


})