<style>
    /* Stile per il div contenitore principale (modal-dialog) */
    .bottom-sheet-dialog {
        /* Posiziona la finestra di dialogo in basso */
        align-items: flex-end;

        /* Assicura che la larghezza sia estesa su dispositivi mobili */
        margin: 0;
        width: 90%;
        max-width: none;
        margin: auto;
        /* Rimuove il limite di larghezza di Bootstrap */
    }

    /* Stile per il contenuto del modal (modal-content) */
    .bottom-sheet-content {
        /* Larghezza su schermi piccoli (full width) */
        width: 100%;

        /* Larghezza massima su schermi desktop/tablet per un aspetto migliore */
        max-width: 500px;
        margin: 0 auto;

        /* Rimuove gli angoli arrotondati sul fondo */
        border-bottom-left-radius: 0;
        border-bottom-right-radius: 0;

        /* Opzionale: aggiunge ombra per un effetto sollevato */
        box-shadow: 0 -10px 20px rgba(0, 0, 0, 0.4);
    }

    /* Regola l'animazione di entrata/uscita */
    .modal.fade .bottom-sheet-dialog {
        /* Inizia più in basso per l'animazione di scorrimento */
        transform: translate(0, 100%);
        transition: transform 0.3s ease-out;
    }

    .modal.show .bottom-sheet-dialog {
        /* Fine posizione (schermo) */
        transform: translate(0, 0);
    }

    /* Contenitore principale della barra di navigazione */
    .nav-bar-pill {
        background-color: #272727b6;
        /* Blu Materiale, simile all'immagine */
        border-radius: 50px;
        /* Rende la forma una pillola */
        padding: 0 1rem;
        /* Spazio laterale */
    }

    /* Stile per la lista di navigazione interna */
    .nav-bar-pill .nav {
        /* Forziamo i link a stare sulla stessa riga e a distribuirsi */
        display: flex;
        justify-content: space-around;
        list-style: none;
        padding: 0;
        margin: 0;
    }

    /* Stile per i singoli link/icone */
    .nav-bar-pill .nav-link {
        color: rgba(255, 255, 255, 0.85);
        /* Bianco leggermente trasparente */
        font-size: 1.5rem;
        /* Dimensione icona */
        padding: 0.75rem 1.25rem;
        /* Spaziatura intorno all'icona */
        transition: color 0.3s ease;
    }

    /* Stile per il link attivo */
    .nav-bar-pill .nav-link.active {
        color: white;
        /* Icona attiva completamente bianca */
    }

    /* Ombra personalizzata (simil-neumorphism) per un effetto 3D fluttuante */
    .shadow-lg {
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.25),
            0 0 15px rgba(0, 0, 0, 0.1);
    }

    /* Regolazioni per il posizionamento fisso in basso e al centro */
    .fixed-bottom {
        /* Impostato su d-flex e justify-content-center nell'HTML per centrare orizzontalmente */
        pointer-events: none;
        /* Permette di cliccare attraverso l'area vuota */
    }

    .fixed-bottom>* {
        pointer-events: auto;
        /* Riattiva i click solo sul contenuto (la nav bar) */
    }

    /* Stile base delle Card */
    .card-clean-style {
        border-radius: 12px;
        transition: transform 0.2s ease-in-out, box-shadow 0.2s ease-in-out;
    }

    /* Effetto al passaggio del mouse (Hover) */
    .card-clean-style:hover {
        transform: translateY(-3px);
        /* Solleva leggermente */
        box-shadow: 0 8px 15px rgba(0, 0, 0, 0.15) !important;
        /* Ombra più definita */
    }

    /* Stile per le icone */
    .card-clean-style i {
        /* display-4 da Bootstrap è già grande, questo è opzionale */
        font-size: 3rem;
    }
</style>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">


<div class="modal fade" id="bottomSheetModal" tabindex="-1" aria-labelledby="bottomSheetLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered bottom-sheet-dialog">
        <div class="container my-5 ">
            <div class="row g-4 ">

                <div class="col-12 col-md-6 col-lg-4">
                    <a href="./index.php" class="text-decoration-none modal-content">
                        <div class="card h-100 shadow-sm border-0 text-center  card-clean-style">
                            <div class="card-body">
                                <i class="bi bi-house-door-fill display-4 mb-2 text-primary"></i>
                                <h5 class="card-title mt-2 mb-0">Home</h5>
                            </div>
                        </div>
                    </a>
                </div>

                <div class="col-12 col-md-6 col-lg-4">
                    <a href="./assegna.php" class="text-decoration-none modal-content">
                        <div class="card h-100 shadow-sm border-0 text-center  card-clean-style">
                            <div class="card-body text-success">
                                <i class="bi bi-link-45deg"></i>
                                <h5 class="card-title mt-2 mb-0">Assegna</h5>
                            </div>
                        </div>
                    </a>
                </div>

                <div class="col-12 col-md-6 col-lg-4">
                    <a href="./ritira.php" class="text-decoration-none modal-content">
                        <div class="card h-100 shadow-sm border-0 text-center  card-clean-style">
                            <div class="card-body text-danger">
                                <i class="bi bi-layer-backward"></i>
                                <h5 class="card-title mt-2 mb-0">Ritira</h5>
                            </div>
                        </div>
                    </a>
                </div>

                <div class="col-12 col-md-6 col-lg-4 ">
                    <a href="./link.php" class="text-decoration-none modal-content">
                        <div class="card h-100 shadow-sm border-0 text-center  card-clean-style  text-info">
                            <div class="card-body">
                                <i class="bi bi-speedometer2 display-4 mb-2 text-info"></i>
                                <h5 class="card-title mt-2 mb-0">Link Veloce</h5>
                            </div>
                        </div>
                    </a>
                </div>

                <div class="col-12 col-md-6 col-lg-4 ">
                    <a href="storia.php" class="text-decoration-none modal-content ">
                        <div class="card h-100 shadow-sm border-0 text-center  card-clean-style text-secondary">
                            <div class="card-body">
                                <i class="bi bi-clock-history display-4 mb-2 text-secondary"></i>
                                <h5 class="card-title mt-2 mb-0">Visualizza Storia</h5>
                            </div>
                        </div>
                    </a>
                </div>

                <div class="col-12 col-md-6 col-lg-4">
                    <a href="./Foglio2.php" class="text-decoration-none modal-content">
                        <div class="card h-100 shadow-sm border-0 text-center  card-clean-style " style="color: #6f42c1;">
                            <div class="card-body">
                                <i class="bi bi-layout-text-sidebar display-4 mb-2" style="color: #6f42c1;"></i>
                                <h5 class="card-title mt-2 mb-0">Visualizza Formattazione</h5>
                            </div>
                        </div>
                    </a>
                </div>

                <div class="col-12 col-md-6 col-lg-4">
                    <a href="campagna.php" class="text-decoration-none">
                        <div class="card h-100 shadow-sm border-0 text-center p-3 card-clean-style">
                            <div class="card-body">
                                <i class="bi bi-globe-americas"></i>
                                <h5 class="card-title mt-2 mb-0">Campagna Speciale</h5>
                            </div>
                        </div>
                    </a>
                </div>

                <div class="col-12 col-md-6 col-lg-4">
                    <a href="./note.php" class="text-decoration-none modal-content  ">
                        <div class="card h-100 shadow-sm border-0 text-center p-3 card-clean-style text-primary">
                            <div class="card-body">
                                <i class="bi bi-journal-bookmark-fill display-4 mb-2 text-primary"></i>
                                <h5 class="card-title mt-2 mb-0">Gestione note</h5>
                            </div>
                        </div>
                    </a>
                </div>

                <div class="col-12 col-md-6 col-lg-4">
                    <a href="./registro.php" class="text-decoration-none modal-content">
                        <div class="card h-100 shadow-sm border-0 text-center p-3 card-clean-style">
                            <div class="card-body">
                                <i class="bi bi-floppy-fill display-4 mb-2 text-dark"></i>
                                <h5 class="card-title mt-2 mb-0">Registro</h5>
                            </div>
                        </div>
                    </a>
                </div>

            </div>
        </div>


    </div>
</div>
<div class="fixed-bottom d-flex justify-content-center mb-2">
    <nav class="nav-bar-pill shadow-lg">
        <ul class="nav">
            <li class="nav-item">
                <a class="nav-link active" href="index.php"><i class="bi bi-house-door"></i></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="assegna.php"><i class="bi bi-link-45deg"></i></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="ritira.php"><i class="bi bi-journal-text"></i></i></a>
            </li>

            <li class="nav-item">
                <button data-bs-toggle="modal" data-bs-target="#bottomSheetModal" class="nav-link" href="#"><i class="bi bi-three-dots"></i></button>
            </li>
        </ul>
    </nav>
</div>