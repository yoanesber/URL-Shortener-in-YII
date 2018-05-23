<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\widgets\LinkPager;
?>
<div class="site-contact">
    <h1>URL Management</h1>

    <p>
        
    </p>

    <div class="row" id="row-form-url-list">
        <div class="col-lg-6">
            <div class="panel panel-default">
                <div class="panel-heading">Form Task</div>
                <div class="panel-body">
                    <form id="url-form">
                        <div class="form-group">
                            <label>URL Original</label>
                            <input class="form-control" placeholder="URL" id="form-url-original">
                        </div>
                        <div class="form-group">
                            <label>URL Conversion</label>
                            <input readonly class="form-control" placeholder="URL Conversion" id="form-url-conversion">
                        </div>
                        <div class="alert alert-info" id="form-url-alert">Please fill URL above.</div>
                    </form>
                </div>
                <div class="panel-footer">
                    <div class="form-group" class="text-right">
                        <button type="button" class="btn btn-primary" id="btn-save-form-url-list">Save</button>
                        <button type="button" class="btn btn-primary" id="btn-update-form-url-list">Save</button>
                        <button type="button" class="btn btn-warning" id="btn-cancel-form-url-list">Cancel</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row" id="row-table-url-list">
        <div class="col-lg-12">
            <button class="btn btn-primary" id="btn-add-form-url-list">Add URL</button>
            <div>&nbsp;</div>
            <table class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>URL Original</th>
                        <th>URL Conversion</th>
                        <th>Added Date</th>
                        <!-- <th>Modifiy</th> -->
                    </tr>
                </thead>
                <tbody>
                    <?php if (sizeof($urlconversion) > 0): ?>
                    <?php for ($i=0; $i<sizeof($urlconversion); $i++): ?>
                    <?php $curr_row = $urlconversion[$i]; ?>
                    <tr>
                        <td class="text-center"><?= $i + 1 ?></td>
                        <td><?= $curr_row['url_original'] ?></td>
                        <td><?= $curr_row['url_conversion'] ?></td>
                        <td><?= $curr_row['createdAt'] ?></td>
                        <!-- <td class="text-center">
                            <button class="btn btn-success btn-xs" onclick="editUrl(<?= $curr_row['id'] ?>)">Edit</button>
                            <button class="btn btn-danger btn-xs" onclick="deleteUrl(<?= $curr_row['id'] ?>)">Delete</button>
                        </td> -->
                    </tr>
                    <?php endfor; ?>
                    <?php else: ?>
                    <tr>
                        <td colspan="3">No task found.</td>
                    </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>