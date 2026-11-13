jQuery(document).ready(function (e) {
  "use strict";
  e(function () {
    e("#contact").validate({
      rules: {
        firstName: { required: !0, minlength: 2 },
        lastName: { required: !0, minlength: 2 },
        email: { required: !0, email: !0 },
        phone: { required: !0 },
        workType: { required: !0 },
        message: { required: !0 },
        hiddenRecaptcha: {
          required: function () {
            return 0 == grecaptcha.getResponse().length;
          },
        },
      },
      messages: {
        firstName: {
          required: "Please type your first name*",
          minlength: "Please type your name correctly*",
        },
        lastName: {
          required: "Please type your last name*",
          minlength: "Please type your name correctly*",
        },

        email: { required: "Please type your e-mail correctly*" },
        phone: { required: "Please enter phone number*" },
        workType: { required: "Please choose your line of work*" },
        message: {
          required: "Please type your message*",
          minlength: "Too short message*",
        },
      },
      submitHandler: function (t) {
        if (0 == grecaptcha.getResponse().length) return !1;
        e(t).ajaxSubmit({
          type: "POST",
          data: e(t).serialize(),
          url: "email/send-email.php",
          success: function () {
            e("#contact :input").attr("disabled", "disabled"),
              e("#contact").fadeTo("slow", 0.15, function () {
                e(this).find(":input").attr("disabled", "disabled"),
                  e(this).find("label").css("cursor", "default"),
                  e("#success").fadeIn();
              }),
              setTimeout(function () {
                e("#success").fadeOut(3000),
                  grecaptcha.reset(),
                  e("#contact")[0].reset();
              }, 3000),
              setTimeout(function () {
                e("#contact").css("opacity", "1");
              }, 5000);
          },
          error: function () {
            e("#contact").fadeTo("slow", 1, function () {
              e("#error").fadeIn();
            });
          },
        });
      },
    });
  });
});
