<div class="page-wrapper">
  <section class="section-wrapper fleet-section">
    <h1>Special Liveries</h1>
    
               <!-- ⬇️ Image Below Menu -->
    <div class="menu-image">
      <img src="/assets/images/specialheader.jpg" alt="Special Liveries">
    </div>
    <div class="eusvaboutusnew-liverygrid">
        <?php
          $liveries = [
            ["edicastle.jpg", "Edinburgh Castle", "A tribute to Scotland’s famous capital landmark and all its majesty, the spirit of Scottish history and beauty can now be seen across Europe."],
            ["greyfriarsbobby.png", "Greyfriars Bobby", "The epitome of honour and loyalty, this ATR 72-600 celebrates Edinburgh’s beloved canine icon and hero. Man’s true best friend."],
            ["blairclan.png", "Blair Clan", "G-ESTK's beautiful tartan tail design pays homage to the \"Clan Blair\" legacy. Their fighting spirit can be tied all the way back to Robert the Bruce “Amo Probos\""],
            ["bellclan.png", "Bell Clan", "Rich in history, the Bell’s have impacted the world from being Knights Templars to famous inventors. It’s only right to recognise their achievements."],
            ["nessie.png", "Nessie", "The Loch Ness monster is embedded in Scottish lore and fantasy. A playful tribute to the favourite legend encourages a visit to its scenic home in Inverness."],
            ["edizoo.png", "Edinburgh Zoo", "Home to over 2,500 animals, the zoo is celebrated for its conservation efforts and satisfying curiosity. Being loved for over 100 years has cemented its place as one of Scotland’s most popular attractions."]
          ];

          foreach ($liveries as $livery) {
            echo '<div class="eusvaboutusnew-liverycard">';
            echo '<a href="#" class="livery-thumb" data-full="/assets/images/specialfleet/' . $livery[0] . '">';
            echo '<img src="/assets/images/specialfleet/' . $livery[0] . '" alt="' . $livery[1] . ' Livery">';
            echo '</a>';
            echo '<h3>' . $livery[1] . '</h3>';
            echo '<p>' . $livery[2] . '</p>';
            echo '</div>';
          }
        ?>
      </div>
    </div>
  </section>
</div>

<!-- Modal Viewer -->
<div id="liveryModal" class="livery-modal">
  <span class="livery-close">&times;</span>
  <img class="livery-modal-content" id="liveryFullImg" alt="Full Size Livery">
</div>

<!-- JavaScript for Modal Interaction -->
<script>
  document.querySelectorAll('.livery-thumb').forEach(thumb => {
    thumb.addEventListener('click', function(e) {
      e.preventDefault();
      const fullImg = this.getAttribute('data-full');
      document.getElementById('liveryFullImg').src = fullImg;
      document.getElementById('liveryModal').style.display = 'block';
    });
  });

  document.querySelector('.livery-close').addEventListener('click', function() {
    document.getElementById('liveryModal').style.display = 'none';
  });

  window.addEventListener('click', function(e) {
    if (e.target === document.getElementById('liveryModal')) {
      document.getElementById('liveryModal').style.display = 'none';
    }
  });
</script>
  </section>
</div>
