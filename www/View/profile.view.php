<main class="flex pageDashboard">
<?php $this->includePartial("sidebar"); ?>
    <div id="pseudo-element"></div>
    <section class="flex flex-column secondPart">
        <div class="flex justify-content-between navbar align-items-center">
            <div class="flex align-items-center">
                <h1>Profil</h1>
            </div>
            <div id="profileDiv">
                <a href="#">
                    <p><?php echo $_SESSION['user']['firstname'] ?><i class="fas fa-user"></i></p>
                </a>
                <button>
                    <i class="far fa-moon"></i>
                    <i class="fas fa-toggle-off"></i>
                </button>
            </div>
        </div>
        <section class="formProfile flex flex-column">

            <div class="flex flex-row align-items-center">
                <div class="profileImg">
                    <img src="https://images.unsplash.com/photo-1527980965255-d3b416303d12?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&ixid=MnwxMTgwOTN8MHwxfHNlYXJjaHw2fHxhdmF0YXJ8ZW58MHx8fHwxNjQ1NDQ1MjIx&ixlib=rb-1.2.1&q=80&w=1080" alt="Avatar">
                </div>

                <div class="flex-column">
                    <p class="title"><?php echo $_SESSION['user']['firstname'] ?></p>
                    <p class="role top-32"><?php echo $_SESSION['user']['role'] == 'admin' ? "Patron" : "Employé"; ?></p>
                </div>

                <button id="editProfile">
                    <i class="far fa-pen "></i>
                </button>

            </div>
            <div class="container">
                <div class="flex flex-row justify-content-between w-full">

                    <!-- Prenom -->
                    <div class="flex flex-column">
                        <label class="greytext" for="firstname">Prénom</label>
                        <input type="text" id="firstname" name="firstname" value="Jean-Pierre" disabled>
                    </div>

                    <!-- Nom de famille -->
                    <div class="flex flex-column">
                        <label class="greytext" for="lastname">Nom de famille</label>
                        <input type="text" id="lastname" name="lastname" value="Jean-Pierre" disabled>
                    </div>

                </div>
                <div class="flex flex-column w-full">
                <!-- Adresse mail -->
                <label class="greytext mt-8" for="email">Adresse mail</label>
                <input type="email" id="email" name="email" value="JeanPierreDelasoul@myspace.fr" disabled>

                <!-- Numéro de telephone-->
                <label class="greytext mt-8" for="phoneNumber">Numero de téléphone</label>
                <input type="tel" id="phoneNumber" name="phoneNumber" value="01 01 01 01 01" disabled>
                </div>
                <div id="sectionButton" class="flex flex-row mt-8 justify-content-end w-full">

                </div>
            </div>
        </section>
    </section>

</main>
