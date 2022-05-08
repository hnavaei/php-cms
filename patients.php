<?php
include_once "inc/header.php";
Db::changePageToLogin();
?>
<!--Delete Modal-->
<div class="modal fade" id="deletePatientModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">اخطار</h5>
                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <div class="modal-body">از حذف فیلد مطمئن هستید ؟</div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">بستن</button>
                <button type="button" class="btn btn-danger" id="delete-patient-btn" data-id="">حذف</button>
            </div>
        </div>
    </div>
</div>
<div class="container-fluid">
    <div class="row m-0 align-items-center">
        <div class="col-md-2"><?php include_once "inc/sidebar.php"; ?></div>
        <div class="col-md-10">
            <div id="patients">
                <div class="content-body mt-5">
                    <div id="message"></div>
                    <table class="table" id="patient-table">
                        <thead>
                        <tr>
                            <th>نام</th>
                            <th>نام خانوادگی</th>
                            <th>سن</th>
                            <th>جنسیت</th>
                            <th>شماره تماس</th>
                            <th>اطلاعات</th>
                            <th>جزئیات</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        $patients = Patient::getAllPatient();
                        if ($patients):
                            foreach ($patients as $row): ?>
                                <tr>
                                    <td><?php echo $row->patient_name ?></td>
                                    <td><?php echo $row->patient_lastname ?></td>
                                    <td><?php echo $row->patient_age ?></td>
                                    <td><?php echo $row->patient_gender ?></td>
                                    <td><?php echo $row->patient_phone ?></td>
                                    <td><?php echo $row->patient_info ?></td>
                                    <td class="d-flex align-items-center justify-content-center">
                                        <a href="#" class="btn btn-danger delete rounded-circle"
                                           data-id="<?php echo $row->patient_id ?>" data-toggle="modal"
                                           data-target="#deletePatientModal"><span class="icon-bin2"></span></a>
                                        <a href="add_patient.php?id=<?php echo $row->patient_id ?>"
                                           class="btn btn-warning rounded-circle"><span class="icon-pencil"></span></a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else:; ?>
                            <div class="alert alert-warning">کاربری یافت نشد</div>
                        <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<?php include_once 'inc/footer.php' ?>

<script>
    const deletePatientBtn = $("#delete-patient-btn"),
        msg = $("#message")
    $("#patient-table").DataTable({
        "language": {
            "url": "//cdn.datatables.net/plug-ins/1.11.4/i18n/fa.json"
        }
    })
    $(document).on("click", ".delete", function (e) {
        e.preventDefault()
        deletePatientBtn.attr("data-id", $(this).attr("data-id"))
    })
    deletePatientBtn.on("click", function () {
        $.ajax({
            url: "http://localhost/hospital/ajax_action.php",
            method: "POST",
            data: {page: "patient", action: "delete_patient", patient_id: $(this).attr("data-id")},
            dataType: "json",
            success: function (response) {
                if (response.hasError)
                    msg.html("<div class='alert alert-danger'>" + response.msg + "</div>")
                else
                    msg.html("<div class='alert alert-success'>" + response.msg + "</div>")
                $(".modal").modal("hide")
               location.reload();
            }
        })
    })

</script>