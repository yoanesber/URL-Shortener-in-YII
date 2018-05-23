<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\widgets\LinkPager;

$this->title = 'TODO List';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-contact">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        Organize life. Never worry about forgetting things again.
    </p>

    <div class="row" id="row-form-todo-list">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">Form Task</div>
                <div class="panel-body">
                    <form id="todolist-form">
                        <div class="form-group">
                            <label>Task Name</label>
                            <input class="form-control" placeholder="Task Name" id="task_name">
                        </div>
                        <div class="form-group">
                            <label>Task Description</label>
                            <Textarea class="form-control" id="task_desc"></Textarea>
                        </div>
                        <div class="form-group">
                            <label>Start Date</label>
                            <div class='input-group datetimepicker'>
                                <input type='text' class="form-control" id='task_start_date'/>
                                <span class="input-group-addon">
                                    <span class="glyphicon glyphicon-calendar"></span>
                                </span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>End Date</label>
                            <div class='input-group datetimepicker'>
                                <input type='text' class="form-control" id='task_end_date'/>
                                <span class="input-group-addon">
                                    <span class="glyphicon glyphicon-calendar"></span>
                                </span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Location</label>
                            <input type='text' class="form-control" id="task_place">
                        </div>
                        <div class="form-group" id="field-task-status">
                            <label>Status</label>
                            <select class="form-control" id="task_status"></select>
                        </div>
                        <div class="alert alert-info" id="alert">Please fill all fields above.</div>
                    </form>
                </div>
                <div class="panel-footer">
                    <div class="form-group" class="text-right">
                        <button type="button" class="btn btn-primary" id="btn-save-form-todo-list">Save</button>
                        <button type="button" class="btn btn-primary" id="btn-update-form-todo-list">Save</button>
                        <button type="button" class="btn btn-warning" id="btn-cancel-form-todo-list">Cancel</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row" id="row-table-todo-list">
        <div class="col-lg-12">
            <button class="btn btn-primary" id="btn-add-form-todo-list">Add Task</button>
            <div>&nbsp;</div>
            <table class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Task Name</th>
                        <th>Task Description</th>
                        <th>Start Date</th>
                        <th>End Date</th>
                        <th>Location</th>
                        <th>Status</th>
                        <th>Added Date</th>
                        <th>Modify</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (sizeof($todolist) > 0): ?>
                    <?php for ($i=0; $i<sizeof($todolist); $i++): ?>
                    <?php $curr_row = $todolist[$i]; ?>
                    <tr>
                        <td class="text-center"><?= $i + 1 ?></td>
                        <td><?= $curr_row['task_name'] ?></td>
                        <td><?= $curr_row['task_desc'] ?></td>
                        <td><?= $curr_row['task_start_date'] ?></td>
                        <td><?= $curr_row['task_end_date'] ?></td>
                        <td><?= $curr_row['task_place'] ?></td>
                        <td class="text-center"><?= $curr_row['status_name'] ?></td>
                        <td class="text-center"><?= date('d M Y H:i:s', strtotime($curr_row['createdAt'])) ?></td>
                        <td class="text-center">
                            <button class="btn btn-success btn-xs" onclick="editTask(<?= $curr_row['id'] ?>)">Edit</button>
                            <button class="btn btn-danger btn-xs" onclick="deleteTask(<?= $curr_row['id'] ?>)">Delete</button>
                        </td>
                    </tr>
                    <?php endfor; ?>
                    <?php else: ?>
                    <tr>
                        <td colspan="9">No task found.</td>
                    </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="modal fade" id="modal-form-todolist" tabindex="-1" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" aria-hidden="true" id="btn-cancel2-delete-todo-list">&times;</button>
                <h4 class="modal-title">Delete Confirmation</h4>
            </div>
            <div class="modal-body">
                Are you sure want to delete di record ?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" id="btn-cancel-delete-todo-list">Cancel</button>
                <button type="button" class="btn btn-primary" id="btn-delete-todo-list">Yes, I'm Sure!</button>
            </div>
        </div>
    </div>
</div>