$(function () {
    $("#loading").hide();

    $("#main_form_profile").on("submit", function (e) {
        e.preventDefault();

        $.ajax({
            url: $(this).attr("action"),
            method: $(this).attr("method"),
            data: new FormData(this),
            processData: false,
            dataType: "json",
            contentType: false,
            beforeSend: function () {
                $(document).find("span.error-text").text("");
            },
            success: function (data) {
                if (data.status == 0) {
                    $.each(data.error, function (prefix, val) {
                        $("span." + prefix + "_error").text(val[0]);
                    });
                } else {
                    $(".affiche").text(data.msg);

                    setInterval(function () {
                        $(".affiche").text("");
                    }, 5000);
                    setInterval(function () {
                        window.location.replace("reload-profile");
                    }, 1500);
                }
            },
            error: function (data) {
                $(".affiche").text("error check prog ..");
            },
        });
    });
    $("#main_form_update_par").on("submit", function (e) {
        e.preventDefault();

        $.ajax({
            url: $(this).attr("action"),
            method: $(this).attr("method"),
            data: new FormData(this),
            processData: false,
            dataType: "json",
            contentType: false,
            beforeSend: function () {
                $(document).find("span.error-text").text("");
            },
            success: function (data) {
                if (data.status == 0) {
                    $.each(data.error, function (prefix, val) {
                        $("span." + prefix + "_error").text(val[0]);
                    });
                } else {
                    $(".affiche").text(data.msg);
                    setInterval(function () {
                        $(".affiche").text("");
                    }, 5000);
                    setInterval(function () {
                        window.location.replace("reload-parametre");
                    }, 1500);
                }
            },
            error: function (data) {
                $(".affiche").text("error check prog ..");
            },
        });
    });

    $("#main_form").on("submit", function (e) {
        e.preventDefault();

        $.ajax({
            url: $(this).attr("action"),
            method: $(this).attr("method"),
            data: new FormData(this),
            processData: false,
            dataType: "json",
            contentType: false,
            beforeSend: function () {
                $(document).find("span.error-text").text("");
            },
            success: function (data) {
                if (data.status == 0) {
                    $.each(data.error, function (prefix, val) {
                        $("span." + prefix + "_error").text(val[0]);
                    });
                } else {
                    $(".affiche").text(data.msg);
                    setInterval(function () {
                        $(".affiche").text("");
                    }, 5000);
                    setInterval(function () {
                        window.location.replace("reload-profile");
                    }, 1500);
                }
            },
            error: function (data) {
                $(".affiche").text("error check prog ..");
            },
        });
    });

    $("#main_form_mp").on("submit", function (e) {
        e.preventDefault();

        $.ajax({
            url: $(this).attr("action"),
            method: $(this).attr("method"),
            data: new FormData(this),
            processData: false,
            dataType: "json",
            contentType: false,
            beforeSend: function () {
                $(document).find("span.error-text").text("");
            },
            success: function (data) {
                if (data.status == 0) {
                    $.each(data.error, function (prefix, val) {
                        $("span." + prefix + "_error").text(val[0]);
                    });
                } else {
                    $(".affiche").text(data.msg);

                    setInterval(function () {
                        $(".autAff").text("");
                    }, 5000);

                    setInterval(function () {
                        window.location.replace("parametre-muso");
                    }, 1500);
                }
            },
            error: function (data) {
                $(".affiche").text("error check prog ..");
            },
        });
    });

    $("#parametre_form").on("submit", function (e) {
        e.preventDefault();

        $.ajax({
            url: $(this).attr("action"),
            method: $(this).attr("method"),
            data: new FormData(this),
            processData: false,
            dataType: "json",
            contentType: false,
            beforeSend: function () {
                $(document).find("span.error-text").text("");
            },
            success: function (data) {
                if (data.status == 0) {
                    $.each(data.error, function (prefix, val) {
                        $("span." + prefix + "_error").text(val[0]);
                    });
                } else {
                    $(".afficheparametre").text(data.msg);
                    setInterval(function () {
                        $(".afficheparametre").text("");
                    }, 5000);
                    setInterval(function () {
                        window.location.replace("reload-parametre");
                    }, 1500);
                }
            },
            error: function (data) {
                $(".afficheparametre").text("error check prog ..");
            },
        });
    });

    $("#password_form").on("submit", function (e) {
        e.preventDefault();

        $.ajax({
            url: $(this).attr("action"),
            method: $(this).attr("method"),
            data: new FormData(this),
            processData: false,
            dataType: "json",
            contentType: false,
            beforeSend: function () {
                $(document).find("span.error-text").text("");
            },
            success: function (data) {
                if (data.status == 0) {
                    $.each(data.error, function (prefix, val) {
                        $("span." + prefix + "_error").text(val[0]);
                    });
                    $(".affichepass").text(data.msg);
                } else {
                    $(".affichepass").text(data.msg);
                    setInterval(function () {
                        $(".affichepass").text("");
                    }, 5000);
                }
            },
            error: function (data) {
                $(".affichepass").text("error check prog ..");
            },
        });
    });

    $("#address_form").on("submit", function (e) {
        e.preventDefault();

        $.ajax({
            url: $(this).attr("action"),
            method: $(this).attr("method"),
            data: new FormData(this),
            processData: false,
            dataType: "json",
            contentType: false,
            beforeSend: function () {
                $(document).find("span.error-text").text("");
            },
            success: function (data) {
                if (data.status == 0) {
                    $.each(data.error, function (prefix, val) {
                        $("span." + prefix + "_error").text(val[0]);
                    });
                    $(".AffAdress").text(data.msg);
                } else {
                    $(".AffAdress").text(data.msg);
                    setInterval(function () {
                        $(".AffAdress").text("");
                    }, 5000);

                    setInterval(function () {
                        window.location.replace("reload-adresse");
                    }, 1500);
                }
            },
            error: function (data) {
                $(".affichepass").text("error check prog ..");
            },
        });
    });

    $("#autorisationPw").on("submit", function (e) {
        e.preventDefault();

        $.ajax({
            url: $(this).attr("action"),
            method: $(this).attr("method"),
            data: new FormData(this),
            processData: false,
            dataType: "json",
            contentType: false,
            beforeSend: function () {
                $(document).find("span.error-text").text("");
            },
            success: function (data) {
                if (data.status == 0) {
                    $.each(data.error, function (prefix, val) {
                        $("span." + prefix + "_error").text(val[0]);
                    });
                } else {
                    $(".autAff").text(data.msg);
                    setInterval(function () {
                        $(".autAff").text("");
                    }, 5000);

                    setInterval(function () {
                        window.location.replace("reload-autorisation");
                    }, 1500);
                }
            },
            error: function (data) {
                $(".affichepass").text("error check prog ..");
            },
        });
    });

    $("#delete").on("submit", function (e) {
        e.preventDefault();

        $.ajax({
            url: $(this).attr("action"),
            method: $(this).attr("method"),
            data: new FormData(this),
            processData: false,
            dataType: "json",
            contentType: false,
            beforeSend: function () {
                $(document).find("span.error-text").text("");
            },
            success: function (data) {
                if (data.status == 0) {
                    $.each(data.error, function (prefix, val) {
                        $("span." + prefix + "_error").text(val[0]);
                    });
                } else {
                    $(".autAff").text(data.msg);

                    setInterval(function () {
                        $(".autAff").text("");
                    }, 5000);

                    setInterval(function () {
                        window.location.reload();
                    }, 1500);
                }
            },
            error: function (data) {
                $(".affichepass").text("error check prog ..");
            },
        });
    });

    $("#modifierDepense").on("submit", function (e) {
        e.preventDefault();

        $.ajax({
            url: $(this).attr("action"),
            method: $(this).attr("method"),
            data: new FormData(this),
            processData: false,
            dataType: "json",
            contentType: false,
            beforeSend: function () {
                $(document).find("span.error-text").text("");
            },
            success: function (data) {
                if (data.status == 0) {
                    $.each(data.error, function (prefix, val) {
                        $("span." + prefix + "_error").text(val[0]);
                    });
                } else {
                    $(".autAff").text(data.msg);
                    setInterval(function () {
                        $(".autAff").text("");
                    }, 5000);

                    setInterval(function () {
                        window.location.reload();
                    }, 1500);
                }
            },
            error: function (data) {
                $(".affichepass").text("error check prog ..");
            },
        });
    });

    $("#addDepense").on("submit", function (e) {
        e.preventDefault();
        $("#loading").show();
        $.ajax({
            url: $(this).attr("action"),
            method: $(this).attr("method"),
            data: new FormData(this),
            processData: false,
            dataType: "json",
            contentType: false,
            beforeSend: function () {
                $(document).find("span.error-text").text("");
            },
            success: function (data) {
                if (data.status == 0) {
                    $("#loading").hide();
                    $.each(data.error, function (prefix, val) {
                        $("span." + prefix + "_error").text(val[0]);
                    });
                } else {
                    $(".autAff").text(data.msg);
                    setInterval(function () {
                        $(".autAff").text("");
                    }, 5000);
                    $("#loading").hide();
                    alert("Depense Ajouter");
                    setInterval(function () {
                        window.location.replace("lister-depense");
                    }, 1500);
                }
            },
            error: function (data) {
                $(".affichepass").text("error check prog ..");
            },
        });
    });

    $("#addDepense-cv").on("submit", function (e) {
        e.preventDefault();
        $("#loading").show();
        $.ajax({
            url: $(this).attr("action"),
            method: $(this).attr("method"),
            data: new FormData(this),
            processData: false,
            dataType: "json",
            contentType: false,
            beforeSend: function () {
                $(document).find("span.error-text").text("");
            },
            success: function (data) {
                if (data.status == 0) {
                    $("#loading").hide();
                    $.each(data.error, function (prefix, val) {
                        $("span." + prefix + "_error").text(val[0]);
                    });
                } else {
                    $(".autAff").text(data.msg);
                    setInterval(function () {
                        $(".autAff").text("");
                    }, 5000);
                    $("#loading").hide();
                    alert("Depense Ajouter");
                    setInterval(function () {
                        window.location.replace("lister-depense-cv");
                    }, 1500);
                }
            },
            error: function (data) {
                $(".affichepass").text("error check prog ..");
            },
        });
    });

    $("#save_note").on("submit", function (e) {
        e.preventDefault();

        $.ajax({
            url: $(this).attr("action"),
            method: $(this).attr("method"),
            data: new FormData(this),
            processData: false,
            dataType: "json",
            contentType: false,
            beforeSend: function () {
                $(document).find("span.error-text").text("");
            },
            success: function (data) {
                if (data.status == 0) {
                    $.each(data.error, function (prefix, val) {
                        $("span." + prefix + "_error").text(val[0]);
                    });
                } else {
                    $(".autAff").text(data.msg);
                    setInterval(function () {
                        $(".autAff").text("");
                    }, 5000);

                    setInterval(function () {
                        window.location.reload();
                    }, 1500);
                }
            },
            error: function (data) {
                $(".affichepass").text("error check prog ..");
            },
        });
    });


    $("#modifier_membre").on("submit", function (e) {
        e.preventDefault();

        $.ajax({
            url: $(this).attr("action"),
            method: $(this).attr("method"),
            data: new FormData(this),
            processData: false,
            dataType: "json",
            contentType: false,
            beforeSend: function () {
                $(document).find("span.error-text").text("");
            },
            success: function (data) {
                if (data.status == 0) {
                    $.each(data.error, function (prefix, val) {
                        $("span." + prefix + "_error").text(val[0]);
                    });
                } else {
                    $(".autAff").text(data.msg);
                    setInterval(function () {
                        $(".autAff").text("");
                    }, 5000);

                }
            },
            error: function (data) {
                $(".affichepass").text("error check prog ..");
            },
        });
    });

    $("#modifierPartenaire").on("submit", function (e) {
        e.preventDefault();

        $.ajax({
            url: $(this).attr("action"),
            method: $(this).attr("method"),
            data: new FormData(this),
            processData: false,
            dataType: "json",
            contentType: false,
            beforeSend: function () {
                $(document).find("span.error-text").text("");
            },
            success: function (data) {
                if (data.status == 0) {
                    $.each(data.error, function (prefix, val) {
                        $("span." + prefix + "_error").text(val[0]);
                    });
                } else {
                    $(".autAff").text(data.msg);
                    setInterval(function () {
                        $(".autAff").text("");
                    }, 5000);

                    setInterval(function () {
                        window.location.reload();
                    }, 1500);
                }
            },
            error: function (data) {
                $(".affichepass").text("error check prog ..");
            },
        });
    });

    $("#save-emprunts").on("submit", function (e) {
        e.preventDefault();

        $.ajax({
            url: $(this).attr("action"),
            method: $(this).attr("method"),
            data: new FormData(this),
            processData: false,
            dataType: "json",
            contentType: false,
            beforeSend: function () {
                $(document).find("span.error-text").text("");
            },
            success: function (data) {
                if (data.status == 0) {
                    $.each(data.error, function (prefix, val) {
                        $("span." + prefix + "_error").text(val[0]);
                    });
                } else {
                    $(".autAff").text(data.msg);
                    setInterval(function () {
                        $(".autAff").text("");
                    }, 5000);

                    setInterval(function () {
                        window.location.reload();
                    }, 1500);
                }
            },
            error: function (data) {
                $(".affichepass").text("error check prog ..");
            },
        });
    });
	
	
		$("#mdCaisse").on("submit", function (e) {
        e.preventDefault();

        $.ajax({
            url: $(this).attr("action"),
            method: $(this).attr("method"),
            data: new FormData(this),
            processData: false,
            dataType: "json",
            contentType: false,
            beforeSend: function () {
                $(document).find("span.error-text").text("");
            },
            success: function (data) {
                if (data.status == 0) {
                    $.each(data.error, function (prefix, val) {
                        $("span." + prefix + "_error").text(val[0]);
                    });
                    $(".afficheCaisse").text(data.msg);
                } else {
                    $(".afficheCaisse").text(data.msg);
                    setInterval(function () {
                        $(".afficheCaisse").text("");
						window.location.reload();
                    }, 5000);
                }
            },
            error: function (data) {
                $(".afficheCaisse").text("error check prog ..");
            },
        });
    });
	
	
	
});
