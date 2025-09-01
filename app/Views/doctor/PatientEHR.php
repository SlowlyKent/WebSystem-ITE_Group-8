<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Patient & EHR</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <style>
    /* Reset / base */
    * { 
      margin:0; padding:0; 
      box-sizing:border-box; 
      font-family: Arial, sans-serif; 
    }
    
    body { 
      background:#f2f2f2; 
      min-height:100vh; 
      width:100%; }

    .hidden { display:none !important; }

    /* Shell with sidebar */
    .dashboard { 
      display:flex; 
      width:100%; 
      min-height:100vh; 
      background:#b9d3c9; 
      padding:40px; }

    /* Main scroll area (keeps sidebar size) */
    .main { 
      flex:1; 
      display:flex; 
      flex-direction:column; 
      gap:20px; 
      overflow-y:auto; 
      padding:20px; 
    }
    .header {
      background:#81c798; 
      height:50px; 
      border-radius:15px; 
      box-shadow:0 10px 10px rgba(0,0,0,.2);
      display:flex; align-items:center; 
      padding:0 20px; color:#052719; 
      font-weight:bold; 
      gap:10px;
    }

    /* Search + list */
    .search-bar {
      display:flex; 
      align-items:center; 
      background:#fff; 
      padding:10px 12px; 
      border-radius:20px;
      box-shadow:0 3px 6px rgba(0,0,0,.1); 
      gap:10px; 
      margin-top:10px;
      margin-bottom:20px;
    }
    .search-bar input { 
      border:none; 
      outline:none; 
      flex:1; }

    table { 
      width:100%; 
      border-collapse:collapse; 
      background:#fff; 
      border-radius:10px; 
      overflow:hidden; 
      box-shadow:0 3px 6px rgba(0,0,0,.1); 
    }
    th, td { 
      padding:12px; 
      text-align:left; 
      border-bottom:1px solid #ddd; 
    }
    th { 
      background:#559680; 
      color:#fff; 
      font-weight:600; 
    }
    .btn-link { 
      background:none; 
      border:none; 
      color:#0b5c4a; 
      cursor:pointer; 
      font-weight:600; 
    }

    .btn-link:hover { 
      text-decoration:underline; 
    }

    /* -------- Patient view layout (center + right mini cards) -------- */
    .ehr-layout {
      display:grid;
      grid-template-columns: 1fr 360px;   /* center content + right mini column */
      gap:24px;
      align-items:start;
    }

    /* Center column cards */
    .card {
      background:#fff; 
      border-radius:12px; 
      box-shadow:0 3px 6px rgba(0,0,0,.1); 
      padding:16px;
    }
    .muted { 
      background:#e8e8e8; 
      color:#333; 
    }
    .card-title { 
      font-weight:700; 
      margin-bottom:10px; 
      color:#052719; 
    }

    .mini-table { 
      width:100%; 
      border-collapse:collapse; 
    }
    .mini-table th, .mini-table td { 
      padding:10px; 
      border-bottom:1px solid #e6e6e6; 
      text-align:left; 
    }
    .mini-table th { 
      color:#555; 
      background:#fafafa; 
      font-weight:600; 
    }

    .two-col {
      display:grid; 
      grid-template-columns: 1fr 1fr; 
      gap:16px; 
      margin-top:16px;
    }
    .pill-row { 
      margin-top:14px; 
      display:flex; 
      gap:10px; 
      flex-wrap:wrap; 
    }
    .pill-btn {
      background:#fff; 
      border:1px solid #c9d7d1; 
      padding:8px 14px; 
      border-radius:10px; 
      cursor:pointer;
      box-shadow:0 1px 2px rgba(0,0,0,.05);
    }
    .pill-btn:hover { 
      background:#81c798; 
      color:#fff; 
      border-color:#81c798; 
    }

    .back-link { 
      margin-left:auto; 
      font-weight:600; 
      color:#0b5c4a; 
      cursor:pointer; }
    .back-link:hover { 
      text-decoration:underline; 
    }

    /* Right mini cards column */
    .sidecol { 
      display:flex; 
      flex-direction:column; 
      gap:16px; 
      position:sticky; 
      top:20px; 
    }
    .mini { 
      background:#fff; 
      border-radius:12px; 
      box-shadow:0 3px 6px rgba(0,0,0,.15); 
      padding:16px; 
    }
    .mini h3 { 
      font-size:16px; 
      font-weight:700; 
      color:#052719; 
      margin-bottom:8px; 
    }
    .mini .subline { 
      font-size:12px; 
      color:#6b6b6b; 
      margin-bottom:8px; 
    }
    .mini label { 
      display:block; 
      font-size:13px; 
      color:#052719; 
      margin:8px 0 4px; 
    }
    .mini input, .mini select, .mini textarea {
      width:100%; 
      border:1px solid #d9d9d9; 
      border-radius:8px; 
      padding:8px; 
      font-size:14px; 
      background:#f9fbfb;
    }
    .mini textarea { 
      min-height:82px; 
      resize:vertical; 
    }
    .mini .actions { 
      display:flex; 
      gap:8px; 
      margin-top:10px; 
    }
    .btn { 
      border:none; 
      border-radius:8px; 
      padding:8px 12px; 
      cursor:pointer; 
      font-weight:600; 
    }
    .btn.primary { 
      background:#81c798; 
      color:#fff; }
    .btn.ghost { 
      background:#052719; 
      color:#fff; }
    .btn.light { 
      background:#eef3f1; 
      color:#0b5c4a; }

    /* Utility container width like in your other pages */
    .container { 
      margin:0 auto; 
      max-width:1200px; 
      width:100%; 
    }

    /* Responsive */
    @media (max-width: 1100px) {
      .ehr-layout { grid-template-columns: 1fr; }
      .sidecol { position:static; }
    }

        @media (max-width: 900px) {
      .dashboard {
        flex-direction: column;
      }
      .filters-actions {
        flex-direction: column;
        gap: 10px;
        align-items: flex-start;
      }
      .new-request {
        align-self: flex-end;
      }
      .sidebar {
        width: 100%;
        flex-direction: row;
        justify-content: space-around;
        border-radius: 0;
        box-shadow: none;
      }
      .main {
        padding: 15px;}
    }
  </style>
</head>
<body>
  <div class="dashboard">
    <!-- Sidebar (kept as-is) -->
    <?= $this->include('components/doctor_sidebar') ?>

    <!-- Main -->
    <main class="main">
      <header class="header">
        <i class="fas fa-user"></i> Patient &amp; EHR
        <span class="back-link hidden" id="backToList" onclick="showList()">← Back to list</span>
      </header>

      <!-- ========== LIST VIEW (default) ========== -->
      <section id="listView" class="container">
        <div class="search-bar">
          <i class="fas fa-search"></i>
          <input type="text" placeholder="Search patient, test, or ID...">
        </div>

        <table>
          <thead>
            <tr>
              <th>Patient ID</th>
              <th>Name</th>
              <th>Age</th>
              <th>Room</th>
              <th>Status</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td>P-0001</td>
              <td>Juan Dela Cruz</td>
              <td>32</td>
              <td>201-A</td>
              <td><button class="btn-link" onclick="openPatientView(this)">View</button></td>
            </tr>
            <tr>
              <td>P-0002</td>
              <td>Maria Santos</td>
              <td>45</td>
              <td>305-B</td>
              <td><button class="btn-link" onclick="openPatientView(this)">View</button></td>
            </tr>
          </tbody>
        </table>
      </section>

      <!-- ========== PATIENT VIEW + RIGHT MINI CARDS ========== -->
      <section id="patientLayout" class="ehr-layout container hidden">
        <!-- Center content -->
        <div>
          <!-- Patient Profile header (muted) -->
          <div class="card muted">
            <div class="card-title">Patient Profile:</div>
            <div id="pvName" style="font-weight:600; margin-bottom:4px;">—</div>
            <div id="pvMeta" style="font-size:13px; color:#444;">Patient Profile: —</div>
          </div>

          <!-- Notes table -->
          <div class="card" style="margin-top:14px;">
            <table class="mini-table">
              <thead>
                <tr>
                  <th style="width:160px;">Date</th>
                  <th>Doctor’s notes</th>
                </tr>
              </thead>
              <tbody id="notesBody">
                <tr><td>0000/00/00</td><td>—</td></tr>
                <tr><td>0000/00/00</td><td>—</td></tr>
                <tr><td>0000/00/00</td><td>—</td></tr>
              </tbody>
            </table>
          </div>

          <!-- Two boxes: Lab Results & Current Prescription -->
          <div class="two-col">
            <div class="card">
              <div class="card-title">Lab Results</div>
              <div id="labResultsBox" style="height:160px; background:#f7f7f7; border-radius:8px;"></div>
            </div>
            <div class="card">
              <div class="card-title">Current Prescription</div>
              <div id="currentRxBox" style="height:160px; background:#f7f7f7; border-radius:8px;"></div>
            </div>
          </div>

          <!-- Buttons row -->
          <div class="pill-row">
            <button class="pill-btn" onclick="toggleMini('noteCard')">Add New Note +</button>
            <button class="pill-btn" onclick="toggleMini('labCard')">Order Lab Request +</button>
            <button class="pill-btn" onclick="toggleMini('rxCard')">Prescribed Med +</button>
          </div>
        </div>

        <!-- Right mini cards -->
        <aside class="sidecol">
          <!-- Add Note -->
          <div id="noteCard" class="mini hidden">
            <h3>Add New Notes – <span id="notePatient">—</span></h3>
            <div class="subline">Date: <span id="noteDate">0000/00/00</span> &nbsp; Time: <span id="noteTime">00:00 AM/PM</span></div>
            <label>Notes:</label>
            <textarea placeholder="Enter notes here"></textarea>
            <div class="actions">
              <button class="btn primary">Save Note</button>
              <button class="btn light" onclick="toggleMini('noteCard')">Cancel</button>
            </div>
          </div>

          <!-- Prescribe Medication -->
          <div id="rxCard" class="mini hidden">
            <h3>Prescribe Medication – <span id="rxPatient">—</span></h3>
            <label>Medicine</label>
            <input type="text" placeholder="e.g., Amoxicillin 500mg">
            <label>Frequency</label>
            <input type="text" placeholder="e.g., 3× daily">
            <label>Duration</label>
            <input type="text" placeholder="e.g., 7 days">
            <label>Notes</label>
            <textarea placeholder="Optional instructions"></textarea>
            <div class="actions">
              <button class="btn primary">Save Prescription</button>
              <button class="btn light" onclick="toggleMini('rxCard')">Cancel</button>
            </div>
          </div>

          <!-- Order Laboratory Test -->
          <div id="labCard" class="mini hidden">
            <h3>Order Laboratory Test – <span id="labPatient">—</span></h3>
            <label>Select Test</label>
            <select>
              <option value="">Choose test…</option>
              <option>Complete Blood Count</option>
              <option>Urinalysis</option>
              <option>X-Ray</option>
              <option>Ultrasound</option>
            </select>
            <label>Others</label>
            <input type="text" placeholder="If not in the list">
            <label>Priority</label>
            <select>
              <option>Routine</option>
              <option>Urgent</option>
              <option>STAT</option>
            </select>
            <div class="actions">
              <button class="btn primary">Submit Order</button>
              <button class="btn light" onclick="toggleMini('labCard')">Cancel</button>
            </div>
          </div>
        </aside>
      </section>
    </main>
  </div>

  <script>
    // Swap to patient detail view when clicking "View"
    function openPatientView(btn) {
      const row = btn.closest('tr');
      const id    = row.children[0].textContent.trim();
      const name  = row.children[1].textContent.trim();
      const age   = row.children[2].textContent.trim();
      const room  = row.children[3].textContent.trim();

      // Fill top profile text
      document.getElementById('pvName').textContent = name;
      document.getElementById('pvMeta').textContent = `Patient Profile: ID ${id} • Age ${age} • Room ${room}`;

      // Put patient name into mini cards
      ['notePatient','rxPatient','labPatient'].forEach(idSpan => {
        document.getElementById(idSpan).textContent = name;
      });

      // Auto-set current date/time in Add Note card
      const now = new Date();
      const yyyy = now.getFullYear();
      const mm = String(now.getMonth()+1).padStart(2,'0');
      const dd = String(now.getDate()).padStart(2,'0');
      let hours = now.getHours();
      const ampm = hours>=12 ? 'PM' : 'AM';
      hours = hours%12 || 12;
      const mins = String(now.getMinutes()).padStart(2,'0');
      document.getElementById('noteDate').textContent = `${yyyy}/${mm}/${dd}`;
      document.getElementById('noteTime').textContent = `${hours}:${mins} ${ampm}`;

      // Show patient view layout
      document.getElementById('listView').classList.add('hidden');
      document.getElementById('patientLayout').classList.remove('hidden');
      document.getElementById('backToList').classList.remove('hidden');

      // Start with all mini cards hidden
      document.querySelectorAll('.sidecol .mini').forEach(c=>c.classList.add('hidden'));
    }

    function showList() {
      document.getElementById('patientLayout').classList.add('hidden');
      document.getElementById('listView').classList.remove('hidden');
      document.getElementById('backToList').classList.add('hidden');
    }

    function toggleMini(id) {
      const el = document.getElementById(id);
      el.classList.toggle('hidden');
      // keep the others as-is so multiple can be open together (like your sketch)
    }
  </script>
</body>
</html>
