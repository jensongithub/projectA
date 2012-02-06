[jQuery Validation Plugin](http://bassistance.de/jquery-plugins/jquery-plugin-validation/) - Form validation made easy
================================

The jQuery Validation Plugin provides drop-in validation for your existing forms, while making all kinds of customizations to fit your application really easy.

If you've wrote custom methods that you'd like to contribute to additional-methods.js, create a branch, add the method there and send a pull request for that branch.

If you've wrote a patch for some bug listed on http://plugins.jquery.com/project/issues/validate, please provide a link to that issue in your commit message.

================================
Built-in rules
================================
required: "This field is required.",
remote: "Please fix this field.",
email: "Please enter a valid email address.",
url: "Please enter a valid URL.",
date: "Please enter a valid date.",
dateISO: "Please enter a valid date (ISO).",
number: "Please enter a valid number.",
digits: "Please enter only digits.",
creditcard: "Please enter a valid credit card number.",
equalTo: "Please enter the same value again.",
accept: "Please enter a value with a valid extension.",
maxlength: $.validator.format("Please enter no more than {0} characters."),
minlength: $.validator.format("Please enter at least {0} characters."),
rangelength: $.validator.format("Please enter a value between {0} and {1} characters long."),
range: $.validator.format("Please enter a value between {0} and {1}."),
max: $.validator.format("Please enter a value less than or equal to {0}."),
min: $.validator.format("Please enter a value greater than or equal to {0}.")