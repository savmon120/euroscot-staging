<div class="page-wrapper">
  <section class="section-wrapper">
    <h1>Our Staff</h1>

    <?php include(__DIR__ . '/../includes/submenu-about.php'); ?>

    <!-- ⬇️ Image Below Menu -->
    <div class="menu-image">
      <img src="/assets/images/staffbackground.jpg" alt="Euroscot Staff Image">
    </div>

    <!-- 👥 Staff Section -->
    <section class="content-area">
      <h3>Meet the Team</h3>
      <p>Our staff are the heart of Euroscot & Air Scotland Virtual — passionate aviators, mentors, and innovators who keep our operations running smoothly and our community thriving. Explore each department below to meet the people behind the callsigns.</p>

      <?php
      $departments = [
        "Airline Board" => [
          [
            "img" => "CS.jpg",
            "name" => "Connor Sullivan - EUS0001",
            "role" => "Founder",
            "email" => "connor.sullivan@euroscot-virtual.co.uk",
            "label" => "Email Connor S"
          ],
          [
            "img" => "CR.png",
            "name" => "Connor Rowe - EUS0002",
            "role" => "Founder",
            "email" => "connor.rowe@euroscot-virtual.co.uk",
            "label" => "Email Connor R"
          ],
        ],
        "Flight Operations" => [
          [
            "img" => "LS.png",
            "name" => "Lewis Saunders - EUS0004",
            "role" => "Operations Team",
            "email" => "lewis@euroscot-virtual.co.uk",
            "label" => "Email Lewis"
          ],
                    [
            "img" => "SW.jpg",
            "name" => "Sam Westley - EUS0043",
            "role" => "Operations Team",
            "email" => "sam.westley@euroscot-virtual.co.uk",
            "label" => "Email Sam"
          ],
          [
            "img" => "WJ1.png",
            "name" => "Will James - EUS0010",
            "role" => "Operations Team",
            "email" => "will@euroscot-virtual.co.uk",
            "label" => "Email Will"
          ],
                                        [
            "img" => "JPstaff.png",
            "name" => "Jordan Philpott - EUS0129",
            "role" => "Creative Designer",
            "email" => "jordan.philpott@euroscot-virtual.co.uk",
            "label" => "Email Jordan"
          ],
                    [
            "img" => "SM.jpg",
            "name" => "Sav M - EUS0037",
            "role" => "Airline Support",
            "email" => "sav.m@euroscot-virtual.co.uk",
            "label" => "Email Sav"
          ],
          [
            "img" => "EH.jpg",
            "name" => "Euan Hay - EUS0008",
            "role" => "Line Technical Pilot",
            "email" => "euan.hay@euroscot-virtual.co.uk",
            "label" => "Email Euan"
          ],
          [
            "img" => "ME.png",
            "name" => "Molly Evans - EUS0136",
            "role" => "Social Media Officer",
            "email" => "molly.evans@euroscot-virtual.co.uk",
            "label" => "Email Molly"
          ],
        ],
      ];
      ?>

      <?php foreach ($departments as $dept => $members): ?>
        <div class="staff-department">
          <h3><?= $dept ?></h3>
          <div class="staff-grid">
            <?php foreach ($members as $person): ?>
              <div class="staff-card">
                <img src="/assets/images/staff/<?= $person['img'] ?>" alt="<?= $person['name'] ?>">
                <h5><?= $person['name'] ?></h5>
                <p class="job-title"><?= $person['role'] ?></p>
                <a href="mailto:<?= $person['email'] ?>"><?= $person['label'] ?></a>
              </div>
            <?php endforeach; ?>
          </div>
        </div>
      <?php endforeach; ?>
    </section>
  </section>
</div>
