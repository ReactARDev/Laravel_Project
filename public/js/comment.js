$('[data-toggle="collapse"]').on('click', function () {
  var $this = $(this),
    $parent = $this.data('parent');
  if ($this.data('parent') === undefined) { /* Just toggle my  */
    $this.find('.glyphicon').toggleClass('glyphicon-plus glyphicon-minus');
    return true;
  }
  
  /* Open element will be close if parent !== undefined */
  var currentIcon = $this.find('.glyphicon');
  currentIcon.toggleClass('glyphicon-plus glyphicon-minus');
  $parent.find('.glyphicon').not(currentIcon).removeClass('glyphicon-minus').addClass('glyphicon-plus');
  
});
$(function ($) {
  
  $.fn.editable.defaults.params = function (params) {
    params._token = $("#_token").data("token");
    return params;
  };
  $.fn.editable.defaults.mode = 'inline';
  $('.editable').editable();


  
  $('body').delegate('#postComment', 'submit', function (e) {
    e.preventDefault();
    // if ($(this).context[3].value != '') {
    if ($(this).find('textarea[name=comment]').value != '') {
      var form = $(this);
      var formAction = $(this).attr("action");
      var data = $(this).serialize();
      axios.post(formAction, data)
      .then(function (response) {
        response.data = response.data.replace(/&lt;/g,'<').replace(/&gt;/g, '>').replace(/&quot;/g, '"');
        var html = $.parseHTML(response.data);

        $('#comments-div').prepend(html);
        if ($('.no-comments').length) {
          $('.no-comments').remove();
        }
        var newCount = $(html).find('[data-comment-count]').data('commentCount');
        $('.comment-count span').text(newCount);

        form[0].reset();

        tinymce.init({
          selector: 'textarea',
          height: 200,
          theme: 'modern',
          plugins: [
            'advlist autolink lists link image charmap print preview hr anchor pagebreak',
            'searchreplace wordcount visualblocks visualchars code fullscreen',
            'insertdatetime media nonbreaking save table contextmenu directionality',
            'emoticons template paste textcolor colorpicker textpattern imagetools codesample toc help'
          ],
          menubar: false,
          toolbar: 'bold italic forecolor backcolor emoticons',
          image_advtab: true,
          templates: [
            { title: 'Test template 1', content: 'Test 1' },
            { title: 'Test template 2', content: 'Test 2' }
          ],
          content_css: [
            '//fonts.googleapis.com/css?family=Lato:300,300i,400,400i',
            '//www.tinymce.com/css/codepen.min.css'
          ],
          setup: function (editor) {
              editor.on('change', function () {
                  editor.save();
              });
            }
         });
      })
      .catch(function (error) {
        console.log(error);
      });
    }
  });
  
  $('body').delegate('.comment-reply-form', 'submit', function (e) {
    e.preventDefault();
    // if ($(this).context[3].value != '') {
    if ($(this).find('textarea[name=comment]').value != '') {
      var replyForm = $(this);
      var formAction = $(this).attr("action");
      var parent = replyForm.context[2].value;
      var data = $(this).serialize();
      axios.post(formAction, data)
      .then(function (response) {
        response.data = response.data.replace(/&lt;/g,'<').replace(/&gt;/g, '>').replace(/&quot;/g, '"');
        var html = $.parseHTML(response.data);

        if ($("#replies_" + parent).length) {
          $('#replies_' + parent).prepend(html);
        }else{
          $("#comment_" + parent).append($.parseHTML('<div id="replies_'+ parent +'">'+response.data+'</div>'));
        }
        replyForm[0].reset();
        replyForm.parent().parent().find('.reply_button').click();
        $('.parent_comment .replies').first().css('margin-left', '10px');

        // Update Posts count
        var newCount = $(html).find('[data-comment-count]').data('commentCount');
        $('.comment-count span').text(newCount);

        tinymce.init({
          selector: 'textarea',
          height: 200,
          theme: 'modern',
          plugins: [
            'advlist autolink lists link image charmap print preview hr anchor pagebreak',
            'searchreplace wordcount visualblocks visualchars code fullscreen',
            'insertdatetime media nonbreaking save table contextmenu directionality',
            'emoticons template paste textcolor colorpicker textpattern imagetools codesample toc help'
          ],
          menubar: false,
          toolbar: 'bold italic forecolor backcolor emoticons',
          image_advtab: true,
          templates: [
            { title: 'Test template 1', content: 'Test 1' },
            { title: 'Test template 2', content: 'Test 2' }
          ],
          content_css: [
            '//fonts.googleapis.com/css?family=Lato:300,300i,400,400i',
            '//www.tinymce.com/css/codepen.min.css'
          ],
          setup: function (editor) {
              editor.on('change', function () {
                  editor.save();
              });
            }
         });
      })
      .catch(function (error) {
        console.log(error);
      });
    }
  });

});

function editComment(e,commentId) {
  e.stopPropagation();
  e.preventDefault();
  $('#commentContent_' + commentId).editable('toggle');
  tinymce.init({
    selector: 'textarea',
    height: 200,
    theme: 'modern',
    plugins: [
      'advlist autolink lists link image charmap print preview hr anchor pagebreak',
      'searchreplace wordcount visualblocks visualchars code fullscreen',
      'insertdatetime media nonbreaking save table contextmenu directionality',
      'emoticons template paste textcolor colorpicker textpattern imagetools codesample toc help'
    ],
    menubar: false,
    toolbar: 'bold italic forecolor backcolor emoticons',
    image_advtab: true,
    templates: [
      { title: 'Test template 1', content: 'Test 1' },
      { title: 'Test template 2', content: 'Test 2' }
    ],
    content_css: [
      '//fonts.googleapis.com/css?family=Lato:300,300i,400,400i',
      '//www.tinymce.com/css/codepen.min.css'
    ],
    setup: function (editor) {
        editor.on('change', function () {
            editor.save();
        });
      }
   });
}

function validateEdit(value){
  alert('hi');
  if($.trim(value) == '') {
    return 'This field is required';
  }
}

function deleteComment(id){
  axios.post("/deleteComment", {commentId:id})
  .then(function (response) {
    if (response.data.deleted) {
      $("#comment_"+ id).remove();
    }
  })
  .catch(function (error) {
    console.log(error);
  });
}