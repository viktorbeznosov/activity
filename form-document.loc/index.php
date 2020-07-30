<!doctype html>
<html lang="en">
<head>
    <link rel="stylesheet" href="./assets/css/bootstrap.css">
    <link rel="stylesheet" href="./assets/css/toastr.css">
    <script src="./assets/js/jquery.js"></script>
    <script src="./assets/js/jquery-ui.min.js"></script>
    <script src="./assets/js/form-builder.min.js"></script>
    <script src="./assets/js/form-render.min.js"></script>
    <script src="./assets/js/bootstrap.js"></script>
    <script src="./assets/js/toastr.js"></script>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>

    <style>
        body{
            background: lightgrey;
            font-family: sans-serif;
        }

        #fb-rendered-form {
            clear:both;
            display:none;
        button{
            float:right;
        }
        }
    </style>

</head>
<body>
    <div class="row">
      <div class="col-md-4 col-sm-6 col-xs-12">
        <div class="form-name form-group">
          <label for="formName">Введите название формы</label>
          <input type="text" class="form-control" id="formName" placeholder="">
        </div>
      </div>
    </div>

    <div id="fb-editor"></div>
    <div id="fb-rendered-form">
        <form action="#"></form>
        <button class="btn btn-default edit-form">Edit</button>
    </div>
    <div class="modal fade" id="confirmSaveForm">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Сохранить форму?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="saveFormButton">Save changes</button>
                </div>
            </div><!-- /.модальное окно-Содержание -->
        </div><!-- /.модальное окно-диалог -->
    </div><!-- /.модальное окно -->
</body>
</html>

<script>
    jQuery(function($) {
        var formBuilder = $('#fb-editor').formBuilder({
            i18n: {
                locale: 'ru-RU'
            },
            disableFields: [
                'button','checkbox-group','file','header','hidden','paragraph'
            ],
            onSave: function() {
                var formDataArray = JSON.parse(formBuilder.formData);
                var formName = $('#formName').val();
                if (formDataArray.length > 0 && formName){
                    $('#confirmSaveForm').modal('show');
                } else {
                    if (formDataArray.length == 0){
                      toastr.warning('Форма пустая!');
                    }
                    if (!formName){
                      toastr.warning('Введите название формы');
                      $('#formName').css('border','1px solid red');
                      $("label[for='formName']").css('color','red');
                    } else {
                      $('#formName').css('border','1px solid #ced4da');
                      $("label[for='formName']").css('color','black');
                    }
                }


            },
            onClearAll: function(formData) {
                $('#formName').attr('data-form_id',null);
            },
        });

        $('.edit-form', $('#fb-rendered-form')).click(function() {
            $('#fb-editor').toggle();
            $('#fb-rendered-form').toggle();
        });

        $('#saveFormButton').on('click', function () {
            //formBuilder.actions.clearFields();
            $('#confirmSaveForm').modal('hide');
            var formName = $('#formName').val();
            var form_id = $('#formName').attr('data-form_id');
            $.ajax({
                url: './save-form.php',
                type: "POST",
                data: {
                    form_id: form_id,
                    name: formName,
                    form: formBuilder.formData
                },
                success: function (responce) {
                    console.log(responce);
                    $('#formName').val('');
                    if (responce){
                      var result = JSON.parse(responce);
                      if (result.id){
                        $('#formName').attr('data-form_id', result.id);

                          $('#fb-editor').toggle();
                          $('#fb-rendered-form').toggle();

                          $('form', $('#fb-rendered-form')).formRender({
                              formData: formBuilder.formData
                          });
                      }
                    }
                },
            });
        });
    });
</script>
