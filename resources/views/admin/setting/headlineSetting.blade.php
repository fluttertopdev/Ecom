<div class="col-md-12 mb-3 display-inline-block">
    <label class="form-label" for="">Headline</label>
    <div id="headline-container">
        @foreach($headline as $row)
        <div class="headline-group d-flex justify-content-between align-items-center">
            <input type="text" class="form-control mb-2" name="headline[]" value="{{ $row->value }}" placeholder="Headline" required>
            <button type="button" class="btn btn-danger btn-sm delete-btn ms-2">Delete</button>
        </div>
        @endforeach
    </div>
    <button type="button" class="btn btn-primary" id="add-headline-btn">Add More Headline</button>
</div>

<script>
    // Function to add new headline input
    document.getElementById('add-headline-btn').addEventListener('click', function() {
        var container = document.getElementById('headline-container');
        var newInputGroup = document.createElement('div');
        newInputGroup.classList.add('headline-group', 'd-flex', 'justify-content-between', 'align-items-center');
        
        var newInput = document.createElement('input');
        newInput.type = 'text';
        newInput.classList.add('form-control', 'mb-2');
        newInput.name = 'headline[]';
        newInput.placeholder = 'Headline';
        newInput.required = true;  // Make the field required
        newInput.setAttribute('data-new', 'true'); // Mark this input as new

        var deleteButton = document.createElement('button');
        deleteButton.type = 'button';
        deleteButton.classList.add('btn', 'btn-danger', 'btn-sm', 'delete-btn', 'ms-2');
        deleteButton.textContent = 'Delete';

        // Add event listener to delete the input field when clicked (AJAX delete)
        deleteButton.addEventListener('click', function() {
            var headlineGroup = deleteButton.closest('.headline-group');
            
            // Check if the input is marked as new (added dynamically)
            if (headlineGroup.querySelector('input').hasAttribute('data-new')) {
                // If it's a new input, remove it from the UI directly without confirmation
                headlineGroup.remove();
            } else {
                // If it's an existing input, show SweetAlert for confirmation before deletion
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!',
                    cancelButtonText: 'Cancel'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Send AJAX request to delete the headline from the database
                        var headlineValue = headlineGroup.querySelector('input').value;
                        fetch('/NewEcom/admin/delete-heading', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                            },
                            body: JSON.stringify({ headline: headlineValue })
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                headlineGroup.remove(); // Remove the headline from the UI if delete was successful
                                Swal.fire('Deleted!', 'Your headline has been deleted.', 'success');
                            } else {
                                Swal.fire('Failed!', 'Something went wrong. Try again.', 'error');
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            Swal.fire('Error!', 'Something went wrong.', 'error');
                        });
                    }
                });
            }
        });

        // Append the new input and delete button to the new input group
        newInputGroup.appendChild(newInput);
        newInputGroup.appendChild(deleteButton);
        container.appendChild(newInputGroup);
    });

    // Initial delete button functionality for the first input
    document.querySelectorAll('.delete-btn').forEach(function(deleteBtn) {
        deleteBtn.addEventListener('click', function() {
            var headlineGroup = deleteBtn.closest('.headline-group');
            var headlineValue = headlineGroup.querySelector('input').value;

            // Check if the input is marked as new (added dynamically)
            if (headlineGroup.querySelector('input').hasAttribute('data-new')) {
                // If it's a new input, remove it from the UI directly without confirmation
                headlineGroup.remove();
            } else {
                // If it's an existing input, show SweetAlert for confirmation before deletion
               Swal.fire({
            title: "Are you sure?",
            text: "You won't be able to revert this!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Yes, delete it!",
            customClass: {
                confirmButton: 'swal-confirm-button-class'
            }
        }).then((result) => {
                    if (result.isConfirmed) {
                        // Send AJAX request to delete the headline from the database
                        fetch('/admin/delete-heading', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                            },
                            body: JSON.stringify({ headline: headlineValue })
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                headlineGroup.remove(); // Remove the headline from the UI if delete was successful
                                
                                   Swal.fire({
                            title: 'Success',
                            text: 'Your headline has been deleted.',
                            icon: 'success',
                            confirmButtonText: 'OK',
                            buttonsStyling: false,
                            customClass: {
                                confirmButton: 'btn btn-success' // Optional: Add a class for styling the button
                            }
                        });
                            } else {
                                Swal.fire('Failed!', 'Something went wrong. Try again.', 'error');
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            Swal.fire('Error!', 'Something went wrong.', 'error');
                        });
                    }
                });
            }
        });
    });
</script>
