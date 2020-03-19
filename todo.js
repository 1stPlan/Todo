$(function() {
  'use strict';


  $('#new_todo').focus();  //#new_todoをフォーカスしてるよ

  // update
  $('#todos').on('click', '.update_todo', function() {

    var id = $(this).parents('li').data('id'); // idを取得

    // ajax処理
    $.post('_ajax.php', {
      id: id,
      mode: 'update',
      // token: $('#token').val()
    }, function(res) {
      if (res.state === '1') {
        $('#todo_' + id).find('.todo_title').addClass('done');   //Classに”done”をつけて何がしたいのかわからない
      } else {
        $('#todo_' + id).find('.todo_title').removeClass('done');
      }
    })
  });
//
  // delete
  $('#todos').on('click', '.delete_todo', function() {

    var id = $(this).parents('li').data('id'); // idを取得

    // ajax処理
    if (confirm('are you sure?')) {
      $.post('_ajax.php', {
        id: id,
        mode: 'delete',
        // token: $('#token').val()
      }, function() {
        $('#todo_' + id).fadeOut(800);
      });
    }
  });
//
  // create
  $('#new_todo_form').on('submit', function() {

    var title = $('#new_todo').val();   // titleを取得

    // ajax処理
    $.post('_ajax.php', {
      title: title,
      mode: 'create',
      // token: $('#token').val()
    }, function(res) {
      // liを追加
      var $li = $('#todo_template').clone();   //コピー
      $li
        .attr('id', 'todo_' + res.id)
        .data('id', res.id)
        .find('.todo_title').text(title);
      $('#todos').prepend($li.fadeIn());
      $('#new_todo').val('').focus();
    });
    return false;
  });

});
