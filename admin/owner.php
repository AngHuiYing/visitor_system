<?php include_once('header.php');



?>
<div class="container mt-5">
    <nav class="navbar navbar-expand-lg navbar-light bg-light mb-4">
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="owner.php">Owner List</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="OwnerRegistration.php">Owner Registration</a>
                </li>
            </ul>
        </div>
    </nav>
    <main>
        <div>
            <h1 class="mb-4">Owner List</h1>
            <form id="search-form" class="form-inline mb-4">
                <input class="form-control mr-2" type="text" id="search-name" placeholder="Search by name">
                <input class="form-control mr-2" type="text" id="search-unit" placeholder="Search by unit">
                <button class="btn btn-primary" type="submit">Search</button>
            </form>
            <table id="owner-table" class="table table-striped">
                <thead>
                    <tr>
                        <th>Owner ID</th>
                        <th>Owner Name</th>
                        <th>Owner Email</th>
                        <th>Owner Phone</th>
                        <th>Owner Unit</th>
                        <th colspan='2'>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Data will be inserted here by JavaScript -->
                </tbody>
            </table>
            <nav id="pagination" aria-label="Page navigation">
                <ul class="pagination">
                    <!-- Pagination links will be inserted here by JavaScript -->
                </ul>
            </nav>
        </div>
    </main>
</div>
<?php include_once('../footer.php');?>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
function fetchOwners(page = 1) {
    let name = $('#search-name').val().trim();
    let unit = $('#search-unit').val().trim();
    
    $.ajax({
        url: 'search.php',
        method: 'GET',
        data: {
            name: name || '',
            unit: unit || '',
            page: page
        },
        dataType: 'json',
        success: function(response) {
            console.log(response);  // Debug: Log response

            if (response.error) {
                alert('Error: ' + response.error);
                return;
            }

            let owners = response.owners;
            let totalPages = response.totalPages;

            let tableBody = '';
            owners.forEach(owner => {
                tableBody += `<tr>
                    <td>${owner.id}</td>
                    <td>${owner.name}</td>
                    <td>${owner.email}</td>
                    <td>${owner.phone}</td>
                    <td>${owner.unit}</td>
                    <td><a href="edit_owner.php?id=${owner.id}" class="btn btn-sm btn-primary">Edit</a></td>
                    <td><a href="delete_owner.php?id=${owner.id}" class="btn btn-sm btn-danger">Delete</a></td>
                </tr>`;
            });

            $('#owner-table tbody').html(tableBody);

            let pagination = '';
            for (let i = 1; i <= totalPages; i++) {
                pagination += `<li class="page-item ${i === page ? 'active' : ''}">
                    <a class="page-link" href="#" data-page="${i}">${i}</a>
                </li>`;
            }

            $('#pagination .pagination').html(pagination);
        },
        error: function() {
            alert('Error loading data. Please try again later.');
        }
    });
}

$(document).ready(function() {
    fetchOwners();
    
    $('#search-form').submit(function(e) {
        e.preventDefault();
        fetchOwners();
    });
    
    $('#pagination').on('click', '.page-link', function(e) {
        e.preventDefault();
        let page = $(this).data('page');
        fetchOwners(page);
    });
});
</script>