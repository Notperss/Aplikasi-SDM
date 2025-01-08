    <div class="col-12">
      <div class="card">
        <div class="card-body">
          <div class="row">
            <div class="d-flex justify-content-between align-items-center ">
              <h4 class="card-title">Jenis Kelamin</h4>
              <a href="{{ url('/export-directorates') }}" class="btn btn-sm btn-success">Export</a>
            </div>

            <div class="col-md-12">
              <table class="table table-sm table-bordered" style="font-size: 80%">
                <thead>
                  <tr>
                    <th class="text-center">Unit Kerja</th>
                    <th class="text-center">Total Karyawan</th>
                    <th class="text-center">Laki-Laki</th>
                    <th class="text-center">Perempuan</th>
                  </tr>
                </thead>
                <tbody>
                  {{-- @php
                    $groupedDirectorates = $directorates->groupBy('is_non');
                  @endphp

                  @forelse ($groupedDirectorates as $isNon => $directoratesGroup) --}}


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
                      <td colspan="4" class="text-bold-500 text-center">
                        {{ $isNon == 1 ? 'DIREKTORAT' : ($isNon == 2 ? 'NON-DIREKTORAT' : 'LAIN-LAIN') }}
                      </td>
                    </tr>
                    @php
                      $total = 0;
                      $totalMale = 0;
                      $totalFemale = 0;
                    @endphp
                    @foreach ($directoratesGroup as $directorate)
                      @php
                        $totalCount = $directorate->divisions->sum(function ($division) {
                            return $division->positions->sum(function ($position) {
                                return optional($position->employee)->employee_status === 'AKTIF' ? 1 : 0;
                            });
                        });

                        $maleCount = $directorate->divisions->sum(function ($division) {
                            return $division->positions->sum(function ($position) {
                                return optional($position->employee)->employee_status === 'AKTIF' &&
                                    optional($position->employee)->gender === 'LAKI-LAKI'
                                    ? 1
                                    : 0;
                            });
                        });

                        $femaleCount = $directorate->divisions->sum(function ($division) {
                            return $division->positions->sum(function ($position) {
                                return optional($position->employee)->employee_status === 'AKTIF' &&
                                    optional($position->employee)->gender === 'PEREMPUAN'
                                    ? 1
                                    : 0;
                            });
                        });

                        $total += $totalCount;
                        $totalMale += $maleCount;
                        $totalFemale += $femaleCount;
                      @endphp
                      <tr>
                        <td class="text-bold-500 ">{{ $directorate->name }}</td>
                        <td class="text-bold-500 text-center">{{ $totalCount }}</td>
                        <td class="text-bold-500 text-center">{{ $maleCount }}</td>
                        <td class="text-bold-500 text-center">{{ $femaleCount }}</td>
                      </tr>
                    @endforeach
                    <tr>
                      <td class="text-bold-500 text-center">Total :</td>
                      <td class="text-bold-500 text-center">{{ $total }}</td>
                      <td class="text-bold-500 text-center">{{ $totalMale }}</td>
                      <td class="text-bold-500 text-center">{{ $totalFemale }}</td>
                    </tr>
                  @empty
                    <tr>
                      <td class="text-bold-500 text-center" colspan="4">No data available in table</td>
                    </tr>
                  @endforelse




                </tbody>
              </table>
            </div>

            <div class="col-md-12">
              <div class="table-responsive">
                <table class="table table-sm table-bordered" style="font-size: 80%">
                  <thead>
                    <tr>
                      <th style="width: 30%" class="text-center">Unit Kerja</th>
                      <th style="width: 10%" class="text-center">Total Karyawan</th>
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
                        <th class="text-center" style="background-color: #5654549d">{{ $category }}</th>
                        <th>LAKI-LAKI</th>
                        <th>PEREMPUAN</th>
                      @endforeach
                    </tr>
                  </thead>
                  <tbody>
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
                        <td colspan="{{ 2 + $uniqueCategories->count() * 2 }}" class="text-bold-500 text-center">
                          {{ $isNon == 1 ? 'DIREKTORAT' : ($isNon == 2 ? 'NON-DIREKTORAT' : 'LAIN-LAIN') }}
                        </td>
                      </tr>

                      @php
                        $totalCounts = [];
                        foreach ($uniqueCategories as $category) {
                            $totalCounts[$category] = ['total' => 0, 'laki' => 0, 'perempuan' => 0];
                        }
                      @endphp

                      @foreach ($directoratesGroup as $directorate)
                        @php
                          // Initialize counts for this directorate
                          $categoryCounts = [];
                          foreach ($uniqueCategories as $category) {
                              $categoryCounts[$category] = ['total' => 0, 'laki' => 0, 'perempuan' => 0];
                          }

                          // Count employees per category and gender
                          foreach ($directorate->divisions as $division) {
                              foreach ($division->positions as $position) {
                                  $employee = $position->employee;
                                  if ($employee && $employee->employee_status === 'AKTIF') {
                                      $categoryName = optional($employee->employeeCategory)->name;
                                      if ($categoryName && isset($categoryCounts[$categoryName])) {
                                          $categoryCounts[$categoryName]['total']++;
                                          if ($employee->gender == 'LAKI-LAKI') {
                                              $categoryCounts[$categoryName]['laki']++;
                                          } elseif ($employee->gender == 'PEREMPUAN') {
                                              $categoryCounts[$categoryName]['perempuan']++;
                                          }
                                          // Update the total counts
                                          $totalCounts[$categoryName]['total']++;
                                          if ($employee->gender == 'LAKI-LAKI') {
                                              $totalCounts[$categoryName]['laki']++;
                                          } elseif ($employee->gender == 'PEREMPUAN') {
                                              $totalCounts[$categoryName]['perempuan']++;
                                          }
                                      }
                                  }
                              }
                          }
                        @endphp
                        <tr>
                          <td class="text-bold-500">{{ $directorate->name }}</td>
                          <td class="text-bold-500 text-center">{{ array_sum(array_column($categoryCounts, 'total')) }}
                          </td>
                          @foreach ($uniqueCategories as $category)
                            <td class="text-center">{{ $categoryCounts[$category]['total'] }}</td>
                            <td class="text-center">{{ $categoryCounts[$category]['laki'] }}</td>
                            <td class="text-center">{{ $categoryCounts[$category]['perempuan'] }}</td>
                          @endforeach
                        </tr>
                      @endforeach

                      <!-- Total Row -->
                      <tr>
                        <td class="text-bold-500 text-center">Total :</td>
                        <td class="text-bold-500 text-center">{{ array_sum(array_column($totalCounts, 'total')) }}</td>
                        @foreach ($uniqueCategories as $category)
                          <td class="text-bold-500 text-center">{{ $totalCounts[$category]['total'] }}</td>
                          <td class="text-bold-500 text-center">{{ $totalCounts[$category]['laki'] }}</td>
                          <td class="text-bold-500 text-center">{{ $totalCounts[$category]['perempuan'] }}</td>
                        @endforeach
                      </tr>
                    @empty
                      <tr>
                        <td class="text-bold-500 text-center" colspan="{{ 2 + $uniqueCategories->count() * 2 }}">
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
    </div>
