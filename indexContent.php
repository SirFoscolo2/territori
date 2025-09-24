
<style>
    .stat-card {
        border-radius: 15px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.05);
        padding: 20px;
        margin-bottom: 15px;
      }
      .stat-icon {
        width: 45px;
        height: 45px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 22px;
        background: rgba(0, 123, 255, 0.1);
        color: #007bff;
      }
      .stat-value {
        font-size: 26px;
        font-weight: 700;
      }
      .bg-sel{
        background: rgba(0, 123, 255, 0.14);
      }
      .stat-label {
        font-size: 15px;
        color: #6c757d;
      }
      .stat-change {
        font-size: 13px;
        color: #28a745;
      }
            .stat-out {
        font-size: 13px;
        color: #a72828ff;
      }
            .action-card {
        border-radius: 15px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.05);
        padding: 20px;
        margin-bottom: 15px;
      }
      .action-btn {
        flex: 1 1 45%;
        border-radius: 12px;
        padding: 15px;
        text-align: center;
        background: #f8f9fa;
        transition: all 0.2s ease;
      }
      .action-btn:hover {
        background: #e9ecef;
        transform: translateY(-2px);
      }
      .action-btn i {
        font-size: 24px;
        margin-bottom: 6px;
        display: block;
      }
      .action-label {
        font-size: 14px;
        font-weight: 600;
      }
      
      .welcome-title {
        font-size: 1.8rem; /* più piccolo */
        font-weight: 600;
        text-align: center;
        background: linear-gradient(90deg, #0d6efd, #20c997);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        
      }
      .welcome-sub {
        text-align: center;
        color: #6c757d;
        font-size: 1rem; /* più piccolo anche il sottotitolo */
      }
      a{
        text-decoration:overline !important;
      }
</style>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">

<div class="container py-3">
      <h1 class="welcome-title">✨ Benvenuto <?= $_SESSION['username'] ?> ✨</h1>
      
    </div>
      
      <!-- Card 1 -->
      <div class="stat-card bg-white d-flex justify-content-between align-items-center">
        <div>
          <div class="stat-label">Territori Attualmente Fuori</div>
          <div class="stat-value"><?=$tFuori['numero_territori_fuori']?></div>
          <div class="stat-out"><?=$terScaduti['numero_territori_usciti']?> Ter. Scaduti</div>
        </div>
        <div class="stat-icon">
          <i class="bi bi-geo-alt"></i>
        </div>
        
      </div>
            <div class="stat-card bg-white d-flex justify-content-between align-items-center">
        <div>
          <div class="stat-label">Media Percorrenza Territorio</div>
          <div class="stat-value"><?=$media['frequenza_media']?></div>
          <div class="stat-change">Negli ultimi 6 mesi</div>
        </div>
        <div class="stat-icon">
         <i class="bi bi-info-square"></i>
        </div>
        
      </div>
      

      <!-- Card con pulsanti -->
      <div class="stat-card bg-sel d-flex justify-content-between align-items-center">
        
        
        <div class="d-flex flex-wrap gap-3">
          <div class="action-btn text-success">
            <i class="bi bi-link-45deg"></i>
            <a href="assegna.php" class="action-label text-success">Assegna</a>
          </div>
          <div class="action-btn text-danger">
            <i class="bi bi-journal-text"></i>
            <a href="ritira.php" class="action-label text-danger">Ritira</a>
          </div>
          <div class="action-btn text-primary">
            <i class="bi bi-clock-history"></i>
            <a href="storia.php" class="action-label text-primary">Storia</a>
          </div>
          <div class="action-btn text-primary">
            <i class="bi bi-journal-text"></i>
            <a href="registro.php" class="action-label text-primary">Registro</a>
          </div>
          

          </div>
    </div>
      

        
      <!-- Card 2 -->
      <div class="stat-card bg-white d-flex justify-content-between align-items-center">
        <div>
          <div class="stat-label">Assegnati Oggi</div>
          <div class="stat-value"><?=$assOggi['numero_territori_assegnati_oggi']?></div>
          <div class="stat-change text-primary"><?php
          
          if(intval($assOggiPlus['differenza_assegnazioni'])>0){
            echo "+";
          }else{
            echo "-";
          }
          echo $assOggiPlus['differenza_assegnazioni'];
          ?> vs ieri</div>
        </div>
        <div class="stat-icon" style="background: rgba(40,167,69,0.1); color:#28a745;">
          <i class="bi bi-person-check"></i>
        </div>
      </div>

      <!-- Card 3 -->
    <div class="stat-card bg-sel d-flex justify-content-between align-items-center">
        
        
        <div class="d-flex flex-wrap gap-3">
          <div class="action-btn text-primary">
            <i class="bi bi-link-45deg"></i>
            <a href="link.php" class="action-label text-primary">Link Veloce</a>
          </div>
          <div class="action-btn text-success">
            <i class="bi bi-journal-text"></i>
            <a href="registro.php" class="action-label text-success">Registro</a>
          </div>
          <div class="action-btn text-warning">
            <i class="bi bi-eye"></i>
            <a href="Foglio2.php" class="action-label text-warning">Visualizza Formattazione</a>
          </div>
          <div class="action-btn text-danger">
            <i class="bi bi-stickies"></i>
            <a href="note.php" class="action-label text-danger">Gestione Note</a>
          </div>
        </div>

        
      

    </div>
  