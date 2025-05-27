@extends('layouts.master')

@section('content')
<!-- Content Header -->
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0">Dashboard</h1>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="#">Home</a></li>
          <li class="breadcrumb-item active">Dashboard</li>
        </ol>
      </div>
    </div>
  </div>
</div>

<!-- Widgets -->
<div class="content">
  <div class="container-fluid">
    <div class="row">
      <!-- Widget 1 -->
      <div class="col-lg-4 col-md-4 col-sm-4">
        <div class="info-box">
          <span class="info-box-icon bg-info"><i class="fas fa-users"></i></span>
          <div class="info-box-content">
            <span class="info-box-text">Employees</span>
            <span class="info-box-number">123</span>
          </div>
        </div>
      </div>

      <!-- Widget 2 -->
      <div class="col-lg-4 col-md-4 col-sm-4">
        <div class="info-box">
          <span class="info-box-icon bg-success"><i class="fas fa-database"></i></span>
          <div class="info-box-content">
            <span class="info-box-text">Payroll Proc</span>
            <span class="info-box-number">0</span>
          </div>
        </div>
      </div>

      <!-- Widget 3 -->
      <div class="col-lg-4 col-md-4 col-sm-4">
        <div class="info-box">
          <span class="info-box-icon bg-warning"><i class="fas fa-laptop"></i></span>
          <div class="info-box-content">
            <span class="info-box-text">Applicants</span>
            <span class="info-box-number">10</span>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Main Content -->
<div class="content">
  <div class="container-fluid">
    <div class="row">
      <!-- Attendance Chart -->
      <div class="col-lg-6">
        <div class="card">
          <div class="card-header border-0">
            <h3 class="card-title">Attendance</h3>
          </div>
          <div class="card-body">
            <canvas id="attendance" style="max-height: 500px;"></canvas>
          </div>
        </div>

        <!-- Recently Added -->
        <div class="card card-success">
          <div class="card-header">
            <h3 class="card-title">Recently Added Employee</h3>
          </div>
          <div class="card-body">
            <table class="table v-middle no-border">
              <tbody>
                <tr>
                  <td><img src="default.png" width="55" height="60" class="img-circle" alt="picture"></td>
                  <td>John Doe</td>
                  <td align="right"><span class="label label-light-danger">2 months ago</span></td>
                </tr>
                <tr>
                  <td><img src="default.png" width="55" height="60" class="img-circle" alt="picture"></td>
                  <td>Jane Smith</td>
                  <td align="right"><span class="label label-light-danger">1 month ago</span></td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>

      <!-- Right column charts -->
      <div class="col-lg-6">
        <!-- Employees Chart -->
        <div class="card">
          <div class="card-header border-0">
            <h3 class="card-title">Employees</h3>
          </div>
          <div class="card-body">
            <canvas id="employees" height="200"></canvas>
          </div>
        </div>

        <!-- Gender Ratio -->
        <div class="card card-success">
          <div class="card-header">
            <h3 class="card-title">Gender Ratio</h3>
          </div>
          <div class="card-body">
            <canvas id="gender"></canvas>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- ChartJS Demo Data -->
<script>
  // Attendance Chart
  new Chart(document.getElementById('attendance'), {
    type: 'polarArea',
    data: {
      labels: ['Jan', 'Feb', 'Mar'],
      datasets: [{
        label: 'Attendance',
        data: [65, 59, 80],
        backgroundColor: ['rgba(255,99,132,0.5)', 'rgba(54,162,235,0.5)', 'rgba(255,206,86,0.5)'],
        borderColor: ['rgba(255,99,132,1)', 'rgba(54,162,235,1)', 'rgba(255,206,86,1)'],
        borderWidth: 1
      }]
    }
  });

  // Employees Chart
  new Chart(document.getElementById('employees'), {
    type: 'bar',
    data: {
      labels: ['Developer', 'Manager', 'HR'],
      datasets: [{
        label: 'Total',
        data: [20, 10, 5],
        backgroundColor: ['rgba(255,99,132,0.5)', 'rgba(54,162,235,0.5)', 'rgba(255,206,86,0.5)'],
        borderColor: ['rgba(255,99,132,1)', 'rgba(54,162,235,1)', 'rgba(255,206,86,1)'],
        borderWidth: 1
      }]
    }
  });

  // Gender Chart
  new Chart(document.getElementById('gender'), {
    type: 'doughnut',
    data: {
      labels: ['Male', 'Female'],
      datasets: [{
        data: [60, 40],
        backgroundColor: ['rgba(54,162,235,0.5)', 'rgba(255,99,132,0.5)'],
        borderColor: ['rgba(54,162,235,1)', 'rgba(255,99,132,1)'],
        borderWidth: 1
      }]
    }
  });
</script>
@stop
