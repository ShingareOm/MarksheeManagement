<?php
?>
<style>
    img#cimg {
        height: 15vh;
        width: 15vh;
        object-fit: cover;
        border-radius: 100% 100%;
    }
</style>
<div class="col-lg-12">
    <div class="card">
        <div class="card-body">
            <form action="" id="manage_user">
                <input type="hidden" name="student_id" value="<?php echo isset($student_id) ? $student_id : NULL ?>">
                <div class="row">
                    <div class="col-md-6 border-right">
                        <div class="form-group">
                            <label for="student_name" class="control-label">Student Name</label>
                            <input type="text" id="student_name" name="student_name" class="form-control form-control-sm" required value="<?php echo isset($student_name) ? $student_name : '' ?>">
                        </div>
                        <div class="form-group">
                            <label for="student_enroll" class="control-label">Student Enrollment</label>
                            <input type="text" id="student_enroll" name="student_enroll" class="form-control form-control-sm" required pattern="[0-9]+" title="Please enter numeric characters only" value="<?php echo isset($student_enroll) ? $student_enroll : '' ?>">
                        </div>
                        <div class="form-group">
                            <label for="student_branch" class="control-label">Student Branch</label>
                            <select id="student_branch" class="form-control form-control-sm" name="student_branch" required>
                                <option value="">Select Branch</option>
                                <option value="Computer Engineering">Computer Engineering</option>
                                <option value="Mechanical Engineering">Mechanical Engineering</option>
                                <option value="Electrical Engineering">Electrical Engineering</option>
                                <option value="Civil Engineering">Civil Engineering</option>
                                <option value="Automobile Engineering">Automobile Engineering</option>
                                <option value="Dress Designing and Garment Manufacturing">Dress Designing and Garment Manufacturing</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="student_phone" class="control-label">Student Phone Number</label>
                            <input type="tel" id="student_phone" class="form-control form-control-sm" name="student_phone" pattern="[0-9]+" title="Please enter numeric characters only" value="<?php echo isset($student_phone) ? $student_phone : '' ?>">
                        </div>
                        <div class="form-group">
                            <label for="semester" class="control-label">Student Semester</label>
                            <select id="semester" class="form-control form-control-sm" name="student_semester" <?php echo !isset($user_id) ? 'required' : '' ?>>
                                <option value="">Select Semester</option>
                                <option value="1">1st Semester</option>
                                <option value="2">2nd Semester</option>
                                <option value="3">3rd Semester</option>
                                <option value="4">4th Semester</option>
                                <option value="5">5th Semester</option>
                                <option value="6">6th Semester</option>
                            </select>
                        </div>
                    </div>
                </div>
                <hr>
                <div class="col-lg-12 text-right justify-content-center d-flex">
                    <button class="btn btn-primary mr-2" onclick="validateForm()">Save</button>
                    <button class="btn btn-secondary" type="button" onclick="location.href = 'index.php?page=user_list'">Cancel</button>
                </div>
            </form>

        </div>
    </div>
</div>

<script>
    function validateForm() {
        var enrollInput = document.getElementById('student_enroll').value;
        var phoneInput = document.getElementById('student_phone').value;
        var branchInput = document.getElementById('student_branch').value;

        var enrollRegex = /^[0-9]+$/; // Regex to allow only numeric characters for enrollment
        var phoneRegex = /^[0-9]+$/; // Regex to allow only numeric characters for phone number
        var branchOptions = ["Computer Engineering", "Mechanical Engineering", "Electrical Engineering", "Civil Engineering", "Automobile Engineering", "Dress Designing and Garment Manufacturing"];

        if (!enrollRegex.test(enrollInput)) {
            alert('Please enter a valid enrollment with only numeric characters.');
            return false;
        }

        if (!phoneRegex.test(phoneInput)) {
            alert('Please enter a valid phone number with only numeric characters.');
            return false;
        }

        if (!branchOptions.includes(branchInput)) {
            alert('Please select a valid branch.');
            return false;
        }

        event.preventDefault();
		start_load()
		$('#msg').html('')
        $.ajax({
            url: 'ajax.php?action=save_stud',
            data: new FormData($('#manage_user')[0]), // Use the same FormData object
            cache: false,
            contentType: false,
            processData: false,
            method: 'POST',
            success: function (resp) {
                console.log(resp);
                if (resp == 1) {
                    alert_toast('Data successfully saved.', "success");
                } else if (resp == 2) {
                    $('#msg').html("<div class='alert alert-danger'>Email already exists.</div>");
                    $('[name="user_email"]').addClass("border-danger");
                    end_load();
                    alert_toast('Email already exists!', "error");
                }
            }

        });
    }

    function displayImg(input, _this) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function (e) {
                $('#cimg').attr('src', e.target.result);
            }

            reader.readAsDataURL(input.files[0]);
        }
    }
</script>
