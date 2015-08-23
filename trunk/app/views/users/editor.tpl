{$html->css("combo.css")}
<div class='x-panel-header'>Редактирование пользователя</div>
<div class='x-panel-body'>
<div id='user_editor'></div>
<script>
var uid="{$user.User.id}";
var username="{$user.User.username}";
var title="{$user.User.title}";
var group_id="{$user.User.group_id}";
</script>
{$javascript->link("user-edit.js")}
</div>
