<!-- Modal -->
<div class="modal fade" id="employeeLevelModal" tabindex="-1" aria-labelledby="employeeLevelModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="employeeLevelModalLabel">Level Jabatan: <span id="modalLevelName"></span></h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <table class="table table-bordered" id="employeeTable">
          <thead>
            <tr>
              <th>NIK</th>
              <th>Nama</th>
              <th>Jabatan</th>
              <th>Level</th>
              <th>Divisi</th>
            </tr>
          </thead>
          <tbody id="employeeList">
          </tbody>
        </table>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
