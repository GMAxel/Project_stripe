
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="css/main.css">
    <title>Document</title>
</head>
<body>
<?php require_once('../layout/navbar/navbar.php'); ?>   

    <!-- <div class="container"> -->
        <h2 class="my-4 text-center">Create Account</h2>
        <form method="post" action="" class="create_acc_form needs-validation" novalidate>
            <div class="row">
                <div class="col">
                    <div class="form-group">
                        <label for="firstname">First Name</label>
                        <input type="text" name="first_name" id="firstname" class="form-control" required>        
                        <div class="invalid-feedback">Enter your firstname</div>
                        <div class="valid-feedback">Accepted</div>
                    </div>
                </div>
                <div class="col">
                    <div class="form-group">
                        <label for="last_name">Last Name</label>
                        <input type="text" name="last_name" id="last_name" class="form-control" required>        
                        <div class="invalid-feedback">Not valid input</div>
                        <div class="valid-feedback">Accepted</div>
                    </div>
                </div>
            </div>
            
            <div class="form-group">
                <label for="email">Email</label>
                <input type="text" name="email" id="email" class="form-control" required>        
                <div class="invalid-feedback">Please enter a valid username</div>

            </div>
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" name="user" id="username" class="form-control" required>        
                <div class="invalid-feedback">Please enter a valid username</div>

            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="pass" name="pass" id="password" class="form-control" required>
            </div>
            <div class="form-check">
                <input type="checkbox" id="accept-terms" class="form-check-input" required>
                <label for="accept_terms" class="form-check-label">Accept Terms & Conditions</label>
            </div>
            <button type="submit" class="mt-3 btn btn-primary">Submit
            </button>
        </form>    
        <script>
            var form = document.querySelector('.needs-validation');

            form.addEventListener('submit', function(event) {
                if (form.checkValidity() === false) {
                    event.preventDefault();
                    event.stopPropagation();
                }
                form.classList.add('was-validated')
            });
            </script>

            <!-- header -->
            <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
            <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>
</html>
