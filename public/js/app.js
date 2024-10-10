$(document).ready(function () {
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
    });

    // Fetch countries
    fetchCountries();

    //fetch country
    function fetchCountries() {
        $.ajax({
            url: "https://restcountries.com/v3.1/all",
            method: "GET",
            success: function (countries) {
                $("#country").empty();
                $("#country").append(
                    '<option value="">Select a country</option>'
                );
                countries.forEach(function (country) {
                    $("#country").append(
                        `<option value="${country.name.common}">${country.name.common}</option>`
                    );
                });
            },
            error: function () {
                alert("Error fetching countries");
            },
        });
    }

    // Combo (Main Add)
    $("#studentForm").on("submit", function (e) {
        e.preventDefault();
        let formData = $(this).serialize();
        let studentId = $("#studentId").val();
        let url = studentId ? `/students/${studentId}` : "/students";
        let method = studentId ? "PUT" : "POST";

        $.ajax({
            url: url,
            type: method,
            data: formData,
            success: function (response) {
                $("#alert")
                    .removeClass("alert-danger")
                    .addClass("alert-success")
                    .text(response.success)
                    .show();
                $("#studentModal").modal("hide");
                location.reload();
            },
            error: function (xhr) {
                $("#alert")
                    .addClass("alert-danger")
                    .text(xhr.responseJSON.message)
                    .show();
            },
        });
    });

    // Update (id)
    $(document).on("click", ".updateBtn", function () {
        const studentId = $(this).data("id");

        $.ajax({
            url: `/students/${studentId}`,
            method: "GET",
            success: function (student) {
                $("#studentId").val(student.id);
                $("#firstName").val(student.first_name);
                $("#lastName").val(student.last_name);
                $("#email").val(student.email);
                $("#phone").val(student.phone);
                $("#addressLine1").val(student.address_line_1);
                $("#addressLine2").val(student.address_line_2);
                $("#city").val(student.city);
                $("#state").val(student.state);
                $("#postalCode").val(student.postal_code);
                $("#country").val(student.country);

                fetchCountries();

                $("#studentModalLabel").text("Update Student");
                $("#submitButton").text("Update");
                $("#studentModal").modal("show");
            },
            error: function () {
                alert("Error fetching student data");
            },
        });
    });

    // View students (id)
    $(document).on("click", ".viewBtn", function () {
        let studentId = $(this).data("id");

        $.ajax({
            url: `/students/${studentId}`,
            type: "GET",
            success: function (data) {
                $("#viewStudentDetails").html(`
                <p><strong>Name:</strong> ${data.first_name} ${
                    data.last_name
                }</p>
                <p><strong>Email:</strong> ${data.email}</p>
                <p><strong>Phone:</strong> ${data.phone}</p>
                <p><strong>Address:</strong> ${data.address_line_1} ${
                    data.address_line_2 ? ", " + data.address_line_2 : ""
                }, ${data.city}, ${data.state}, ${data.postal_code}, ${
                    data.country
                }</p>
            `);
            },
        });
    });

    // Delete (id)
    $(document).on("click", ".deleteBtn", function () {
        const studentId = $(this).data("id");

        if (confirm("Are you sure you want to delete this student?")) {
            $.ajax({
                url: `/students/${studentId}`,
                method: "DELETE",
                success: function (response) {
                    $("#alert")
                        .removeClass("alert-danger")
                        .addClass("alert-success")
                        .text(response.message)
                        .show();
                    setTimeout(() => {
                        $("#alert").fadeOut();
                    }, 3000);
                    location.reload();
                },
                error: function (xhr) {
                    const errorMessage =
                        xhr.responseJSON.message || "Error deleting student";
                    $("#alert")
                        .removeClass("alert-success")
                        .addClass("alert-danger")
                        .text(errorMessage)
                        .show();
                },
            });
        }
    });

    // // Data Tables (opt)
    // $(document).ready(function() {
    //     const table = $('#myDataTable').DataTable({
    //         paging: true,           
    //         searching: true,        
    //         ordering: true,         
    //         info: true,             
    //         lengthChange: true,     
    //     });
    
    //     function populateTable(students) {
    //         table.clear(); 
    
    //         students.forEach((student, index) => {
    //             table.row.add([
    //                 index + 1,
    //                 student.first_name,
    //                 student.last_name,
    //                 student.email,
    //                 `
    //                     <i class="fas fa-eye viewBtn" style="cursor: pointer;" title="View" data-id="${student.id}" data-toggle="modal" data-target="#viewModal"></i>
    //                     <i class="fas fa-pencil-alt updateBtn" style="cursor: pointer;" title="Update" data-id="${student.id}" data-toggle="modal" data-target="#studentModal"></i>
    //                     <i class="fas fa-trash-alt deleteBtn" style="cursor: pointer;" title="Delete" data-id="${student.id}"></i>
    //                 `
    //             ]).draw(); 
    //         });
    //     }
    // });
    
});
