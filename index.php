<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>CRUD</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</head>

<body>
    <!-- aici includem proccess.php in index  -->
    <?php require_once 'process.php'; ?>

    <?php
    //aici verificam daca mesajul a fost afisat 
    if (isset($_SESSION['message'])) :

    ?>
        <!-- //aici folosim clasa bootstrap  alert pentru a afisa mesajul -->
        <!-- schimband culoarea mesajului -->
        <div class="alert alert-<?= $_SESSION['msg_type'] ?>">

            <!-- aici afisam mesajul -->
            <?php echo $_SESSION['message'];
            unset($_SESSION['message']);
            ?>
        </div>
    <?php endif ?>

    <div class="container">

        <?php
        //aici ne conectam la baza de date si vom stoca in variabila result datele
        //vom selecta tot ce se afla in baza de date pentru a afisa 
        $mysqli = new mysqli('localhost', 'root', 'parola123', 'crud') or die(mysqli_error($mysqli));
        $result = $mysqli->query("select * from data") or die($mysqli->error);

        ?>

        <div class="row justify-content-center">

            <!-- //aici cream un table in care  care afisam datele -->
            <table class="table">

                <thead>
                    <tr>
                        <th>Nume</th>
                        <th>Adresa</th>
                        <th colspan="2">Action</th>
                    </tr>

                </thead>
                <?php
                //aici cu ajutorul while si  fetch_assoc parcurgem pe rand datele si le vom afisa
                //si le stocam in variabila row
                while ($row = $result->fetch_assoc()) :

                ?>

                    <tr>
                        <!-- //aici printam valorile din nume si adresa -->
                        <td><?php echo $row['nume']; ?></td>
                        <td><?php echo $row['adresa']; ?></td>
                        <td>
                            <!-- //aici avem butoanele de delete si edit -->
                            <!-- facem legatura intre butoane si unde se vor face modificarile
                            butonul de edit fiind in index.php si cel de delete in proccess.php -->
                            <a href="index.php?edit=<?php echo $row['id']; ?>" class="btn btn-info">Edit</a>
                            <a href="process.php?delete=<?php echo $row['id']; ?>" class="btn btn-danger">Delete</a>
                        </td>

                    </tr>
                <?php endwhile; ?>
            </table>

        </div>

        <?php
        //aici avem o functie pentrua afisa ce se afla in baza de date 
        function pre_r($array)
        {
            echo '<pre>';
            print_r($array);
            echo '<pre>';
        }

        ?>
        <div class="row justify-content-center">

            <!-- am folosit un form cu 2 imput-uri pentru nume si adressa   si un buton  -->
            <!-- am folosoit diferite clase bootstrap pentru inputuri si buton -->
            <!-- in acest form am folosit metoda post  -->

            <form action="process.php" method="POST">
                <!-- aici accesam id din metoda post care v-a fi invizibil fata de user  -->
                <input type="hidden" name="id" value="<?php echo $id; ?>">

                <div class="form-group">
                    <label>Nume</label>
                    <input type="text" name="nume" class="form-control" value="<?php echo $nume; ?>" placeholder="Scrie numele">
                </div>
                <div class="form-group">
                    <label>Adresa</label>
                    <input type="text" name="adresa" class="form-control" value="<?php echo $adresa ?>" placeholder="Scrie Adresa">
                </div>
                <div class="from-group">
                    <?php
                    //aici verificam daca apasam butonul edit, butonul de save se va schimba in update
                    if ($update == true) :
                    ?>
                        <button type="submit" class="btn btn-primary" name="update">Update</button>

                    <?php else : ?>
                        <button type="submit" class="btn btn-primary" name="save">Save </button>

                    <?php endif; ?>
                </div>
            </form>
        </div>
    </div>
</body>

</html>