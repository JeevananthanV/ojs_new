jQuery(document).ready(function (e) {
  "use strict";
  e(function () {
    e("#career").validate({
      rules: {
        firstName: { required: !0, minlength: 2 },
        lastName: { required: !0, minlength: 2 },
        email: { required: !0, email: !0 },
        phone: { required: !0 },
        currentEmployeeStatus: { required: true },
        position: { required: !0, minlength: 2 },
        currentCTC: { required: !0 },
        expectedCTC: { required: !0 },
        experience: { required: !0 },
        relocate: { required: true },
        immediateJoin: { required: true },
        resume: { required: true },
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
        currentEmployeeStatus: { required: "Please select any one*" },
        position: { required: "Please enter your position*" },
        currentCTC: { required: "Please enter your current CTC*" },
        expectedCTC: { required: "Please  enter your expected CTC*" },
        experience: { required: "Please enter experience*" },
        relocate: { required: "Please choose yes or no*" },
        immediateJoin: { required: "Please choose yes or no*" },
        resume: { required: "Please upload your resume*" },
      },
      submitHandler: function (t) {
        if (0 == grecaptcha.getResponse().length) return !1;
        e(t).ajaxSubmit({
          type: "POST",
          data: e(t).serialize(),
          url: "email/send-email-career.php",
          success: function () {
            e("#career :input").attr("disabled", "disabled"),
              e("#career").fadeTo("slow", 0.15, function () {
                e(this).find(":input").attr("disabled", "disabled"),
                  e(this).find("label").css("cursor", "default"),
                  e("#success").fadeIn();
              }),
              setTimeout(function () {
                e("#success").fadeOut(3000),
                  grecaptcha.reset(),
                  e("#career")[0].reset();
              }, 3000),
              setTimeout(function () {
                e("#career").css("opacity", "1");
              }, 5000);
          },
          error: function () {
            e("#career").fadeTo("slow", 1, function () {
              e("#error").fadeIn();
            });
          },
        });
      },
    });
  });
});
