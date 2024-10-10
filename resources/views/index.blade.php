<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Student Management</title>

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/2.1.8/css/dataTables.bootstrap5.css">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    
</head>

<body>

    <div class="header">
        <h1>Student Management</h1>
    </div>

    <div class="container content mt-5">
        <button class="btn btn-success mb-3" data-toggle="modal" data-target="#studentModal">Create New Student</button>


        <div id="alert" class="alert alert-danger" style="display: none; position: absolute; top: 20px; right: 20px; z-index: 1050;"></div>

        <!-- Modal Add / Update -->
        <div class="modal fade" id="studentModal" tabindex="-1" aria-labelledby="studentModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="studentModalLabel">Add New Student</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form id="studentForm">
                            <input type="hidden" id="studentId" name="studentId">
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="firstName">First Name</label>
                                    <input type="text" class="form-control" id="firstName" name="first_name" required>
                                    <div class="invalid-feedback">Please provide a valid first name.</div>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="lastName">Last Name</label>
                                    <input type="text" class="form-control" id="lastName" name="last_name" required>
                                    <div class="invalid-feedback">Please provide a valid last name.</div>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="email">Email</label>
                                    <input type="email" class="form-control" id="email" name="email" required>
                                    <div class="invalid-feedback">Please provide a valid email.</div>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="phone">Phone</label>
                                    <input type="text" class="form-control" id="phone" name="phone" required>
                                    <div class="invalid-feedback">Please provide a valid phone number.</div>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-12">
                                    <label for="addressLine1">Address Line 1</label>
                                    <textarea class="form-control" id="addressLine1" name="address_line_1" rows="2"
                                        required></textarea>
                                    <div class="invalid-feedback">Please provide an address.</div>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-12">
                                    <label for="addressLine2">Address Line 2</label>
                                    <textarea class="form-control" id="addressLine2" name="address_line_2"
                                        rows="2"></textarea>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="city">City</label>
                                    <input type="text" class="form-control" id="city" name="city" required>
                                    <div class="invalid-feedback">Please provide a valid city.</div>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="state">State</label>
                                    <input type="text" class="form-control" id="state" name="state" required>
                                    <div class="invalid-feedback">Please provide a valid state.</div>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="postalCode">Postal Code</label>
                                    <input type="text" class="form-control" id="postalCode" name="postal_code" required>
                                    <div class="invalid-feedback">Please provide a valid postal code.</div>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="countrySelect">Country</label>
                                    <select id="country" name="country" class="form-control" required>
                                        <option value="">Select a country</option>
                                    </select>
                                    <div class="invalid-feedback">Please select a country.</div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-primary" id="submitButton">Register</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal View -->
        <div class="modal fade" id="viewModal" tabindex="-1" aria-labelledby="viewModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="viewModalLabel">Student Details</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body" id="viewStudentDetails">
                    </div>
                </div>
            </div>
        </div>

        <h2 class="text-center">Registered Students List</h2>

        <!--table-->
        <table id="myDataTable" class="table">
            <thead>
                <tr>
                    <th>No.</th>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Email</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($students as $student)
                        <tr data-id="{{ $student->id }}">
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $student->first_name }}</td>
                        <td>{{ $student->last_name }}</td>
                        <td>{{ $student->email }}</td>
                        <td class="action-icons">
                            <i class="fas fa-eye viewBtn" style="cursor: pointer;" title="View" data-id="{{ $student->id }}"
                                data-toggle="modal" data-target="#viewModal"></i>
                            <i class="fas fa-pencil-alt updateBtn" style="cursor: pointer;" title="Update"
                                data-id="{{ $student->id }}" data-toggle="modal" data-target="#studentModal"></i>
                            <i class="fas fa-trash-alt deleteBtn" style="cursor: pointer;" title="Delete"
                                data-id="{{ $student->id }}"></i>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

    </div>

    <footer>
        <p>Created by Jaymin Raabari | <a href="https://www.linkedin.com/in/jayminraabari/" target="_blank">LinkedIn</a>
        </p>
    </footer>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <script src="{{ asset('js/app.js') }}"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.datatables.net/2.1.8/js/dataTables.js"></script>
    <script src="https://cdn.datatables.net/2.1.8/js/dataTables.bootstrap5.js"></script>
    <script>
        $(document).ready(function () {
            $('#myDataTable').DataTable();
        }); 
    </script>

</body>
</html>