<div class="col-12">
  <div class="card">
    <div class="card-body">
      <div class="row">
        <div class="d-flex justify-content-between align-items-center">
          <h4 class="card-title">Kategori Karyawan</h4>
          <a href="{{ url('/export-employees-categories') }}" class="btn btn-sm btn-success">Export</a>
        </div>

        <div class="col-md-12">
          <table class="table table-sm table-bordered" style="font-size: 80%">
            <thead>
              <tr>
                <th style="width: 50%; text-align: center">Unit Kerja</th>
                <th style="width: 10%; text-align: center">Total Karyawan</th>
                @php
                  // Collect unique employee categories for the table header
                  $uniqueCategories = collect();
                  foreach ($directorates as $directorate) {
                      foreach ($directorate->divisions as $division) {
                          foreach ($division->positions as $position) {
                              $categoryName = optional($position->employee)->employeeCategory->name ?? null;
                              if ($categoryName) {
                                  $uniqueCategories->push($categoryName);
                              }
                          }
                      }
                  }
                  $uniqueCategories = $uniqueCategories->unique();
                @endphp

                @foreach ($uniqueCategories as $category)
                  <th>{{ $category }}</th>
                @endforeach
              </tr>
            </thead>
            <tbody>
              {{-- @php
                $groupedDirectorates = $directorates->groupBy('is_non');
              @endphp --}}

              @php
                // Group and order the directorates
                $groupedDirectorates = $directorates->groupBy('is_non')->sortKeysUsing(function ($key1, $key2) {
                    $order = [1, 2]; // Define the desired order for is_non
                    $index1 = array_search($key1, $order) !== false ? array_search($key1, $order) : count($order);
                    $index2 = array_search($key2, $order) !== false ? array_search($key2, $order) : count($order);
                    return $index1 <=> $index2;
                });
              @endphp

              @forelse ($groupedDirectorates as $isNon => $directoratesGroup)
                <tr>
                  <td colspan="{{ 2 + $uniqueCategories->count() }}" class="text-bold-500 text-center">
                    {{ $isNon == 1 ? 'DIREKTORAT' : ($isNon == 2 ? 'NON-DIREKTORAT' : 'LAIN-LAIN') }}
                  </td>
                </tr>

                @php
                  $totalCounts = [];
                  foreach ($uniqueCategories as $category) {
                      $totalCounts[$category] = 0;
                  }
                @endphp

                @foreach ($directoratesGroup as $directorate)
                  @php
                    // Initialize counts for this directorate
                    $categoryCounts = [];
                    foreach ($uniqueCategories as $category) {
                        $categoryCounts[$category] = 0;
                    }

                    // Count employees per category
                    foreach ($directorate->divisions as $division) {
                        foreach ($division->positions as $position) {
                            $employee = $position->employee;
                            if ($employee && $employee->employee_status === 'AKTIF') {
                                $categoryName = optional($employee->employeeCategory)->name;
                                if ($categoryName && isset($categoryCounts[$categoryName])) {
                                    $categoryCounts[$categoryName]++;
                                    $totalCounts[$categoryName]++;
                                }
                            }
                        }
                    }
                  @endphp
                  <tr>
                    <td class="text-bold-500">{{ $directorate->name }}</td>
                    <td class="text-bold-500" style="text-align: center">{{ array_sum($categoryCounts) }}</td>
                    @foreach ($uniqueCategories as $category)
                      <td style="text-align: center">{{ $categoryCounts[$category] }}</td>
                    @endforeach
                  </tr>
                @endforeach

                <!-- Total Row -->
                <tr>
                  <td class="text-bold-500 text-center">Total :</td>
                  <td class="text-bold-500 text-center">{{ array_sum($totalCounts) }}</td>
                  @foreach ($uniqueCategories as $category)
                    <td class="text-bold-500 text-center">{{ $totalCounts[$category] }}</td>
                  @endforeach
                </tr>
              @empty
                <tr>
                  <td class="text-bold-500 text-center" colspan="{{ 2 + $uniqueCategories->count() }}">
                    No data available in table
                  </td>
                </tr>
              @endforelse
            </tbody>
          </table>
        </div>

      </div>
    </div>
  </div>
</div>
