<td> <?php $row["a"]; ?></td>
                <td> <?php $row["g"]; ?></td>
                <td> <?php $row["d"]; ?></td>
                <td> <?php $row["e"]; ?></td>
                <td> <?php $row["p"]; ?></td>
                <td> <?php $row["r"]; ?></td>
                <td> <?php $row["p"]; ?></td>
                <td> <?php $row["s"]; ?></td>
                <td> <?php $row["t"]; ?></td>
                <td> <?php $row["sa"]; ?></td>
                <td> <?php $row["b"]; ?></td>
                <td> <?php $row["a"]; ?></td>
                <td> <?php $row["l"]; ?></td>


                SELECT r.`id` AS i, r.`age` AS a, `gender` AS g, d.`description` AS d, e.`description` AS e, `promoted` AS p, r.`review` AS r, r.`projects` AS pr, r.`salary` AS s , r.`tenure` AS t, r.`satisfaction` AS sa, r.`bonus` AS b, r.`avg_hrs_month` AS av, r.`left_employee` AS l
                        FROM `retention_data` r
                        JOIN `education_list` e ON e.id=r.education
                        JOIN `department_list` d ON d.id=r.department LIMIT 100;
                        <?php
  // Connect to the database
  $conn = mysqli_connect('localhost', 'username', 'password', 'database_name');
  
  //total employees
  $total_employees = mysqli_fetch_array(mysqli_query($conn,"SELECT COUNT(*) AS total_employee FROM `retention_data`;"))['total_employee'];
  
  //total employees who left
  $attrition = mysqli_fetch_array(mysqli_query($conn,"SELECT COUNT(*) AS total_attrition FROM `retention_data` WHERE `left_employee`=1;"))['total_attrition'];
  
  //attrition rate
  $attrition_rate = number_format(($attrition/$total_employees)*100, 2, ".", "");
  
  //active employees
  $active_employees = $total_employees - $attrition;
  
  //average age
  $average_age = round(mysqli_fetch_array(mysqli_query($conn,"SELECT AVG(`age`) as avg_age FROM `retention_data`;"))['avg_age']);
  
  //list of educations
  $education = mysqli_query($conn,"SELECT id, description FROM `education_list`;");
?>

<table>
  <tr>
    <th>Total Employees</th>
    <th>Active Employees</th>
    <th>Attrition</th>
    <th>Attrition Rate</th>
    <th>Average Age</th>
  </tr>
  <tr>
    <td><?php echo $total_employees; ?></td>
    <td><?php echo $active_employees; ?></td>
    <td><?php echo $attrition; ?></td>
    <td><?php echo $attrition_rate; ?>%</td>
    <td><?php echo $average_age; ?></td>
  </tr>
</table>

<select class="form-select mb-3" name="education" id="education-select">
  <option value="" selected>All</option>
  <?php while ($educations = mysqli_fetch_assoc($education)) { ?>
    <option value="WHERE education LIKE <?php echo $educations['id'];?>">
      <?php echo $educations['description'];?>
    </option>
  <?php }; ?>
</select>

<script>
  const educationSelect = document.getElementById('education-select');
  educationSelect.addEventListener('change', function(event) {
    const selectedOption = event.target.value;
    // Call your desired function with the selected option value as an argument
    myFunction(selectedOption);
  });
  
  function myFunction(selectedOption) {
    // Do something with the selected option value
    console.log('Selected option:', selectedOption);
  }
</script>
        <div class="col-4">
                <form method="POST">
                    <select class="form-select mb-3" name="education">
                        <option value="" selected>All</option>
                        <?php while ($educations=mysqli_fetch_assoc($education)){?>
                            <option value="WHERE education LIKE <?php echo $educations['id'];?>">
                                <?php echo $educations['description'];?>
                            </option>
                        <?php };?>
                        <input class="btn btn-success btn-md" type="submit" value="submit" name="pass">
                    </select>
                </form>
            </div>
