<style>
  .popup-container {
    width: 100%;
    height: 100vh;
    position: absolute;
    z-index: 10000;
    left: 0;
    top: 0;
    display: none;
    align-items: center;
    justify-content: center;
  }

  .popup-container.active {
    display: flex;
  }

  .popup-container .popup-card {
    width: 400px;
    background-color: #fdba74;
  }

  .navigate-btn {
    background-color: #fb923c;
    padding: .25rem 1rem;
    border-radius: 0.265rem;
    font-size: 14px;
    font-weight: bold;

  }

</style>

@if(auth()->user()->profile && auth()->user()->profile->nakes)

@elseif(auth()->user()->modelHasRole[0]->role->name == "super_admin")

@elseif(auth()->user()->modelHasRole[0]->role->name == "dinas")

@else
<div class="popup-container" id="modal">
  <div class="popup-card h-fit rounded-lg p-4 shadow-lg">
    <div class="flex items-center justify-between">
      <h1 class="text-lg font-semibold">Peringatan</h1>
      <button id="close-modal">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
          <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
        </svg>
      </button>
    </div>
    <div style="margin: 1rem 0;">
      <p>
        Waktu sudah habis, silahkan input kembali pencatatan jentik
      </p>
    </div>
    <button class="navigate-btn">
      Pergi
    </button>
  </div>
</div>
<div style="width: 100%; height: 4em; display: flex; align-items: center; justify-content: center;">
  <span id="cd-days">00</span>:
  <span id="cd-hours">00</span>:
  <span id="cd-minutes">00</span>:
  <span id="cd-seconds">00</span>
</div>

<script>
  let timer = function(date) {
    if (!date) {
      document.getElementById('cd-days').innerHTML = "00";
      document.getElementById('cd-hours').innerHTML = "00";
      document.getElementById('cd-minutes').innerHTML = "00";
      document.getElementById('cd-seconds').innerHTML = "00";
      return;
    }

    let timer = Math.round(new Date(date).getTime() / 1000) - Math.round(new Date().getTime() / 1000);
    let minutes, seconds;
    setInterval(function() {
      if (--timer < 0) {
        timer = 0;
      }
      days = parseInt(timer / 60 / 60 / 24, 10);
      hours = parseInt((timer / 60 / 60) % 24, 10);
      minutes = parseInt((timer / 60) % 60, 10);
      seconds = parseInt(timer % 60, 10);
      days = days < 10 ? "0" + days : days;
      hours = hours < 10 ? "0" + hours : hours;
      minutes = minutes < 10 ? "0" + minutes : minutes;
      seconds = seconds < 10 ? "0" + seconds : seconds;
      document.getElementById('cd-days').innerHTML = days;
      document.getElementById('cd-hours').innerHTML = hours;
      document.getElementById('cd-minutes').innerHTML = minutes;
      document.getElementById('cd-seconds').innerHTML = seconds;
    }, 1000);
  }

  async function getData() {
    try {
      const res = await fetch('/api/timer');
      const json = await res.json();

      if (!json || !json.reported_date) {
        timer(null);
        return;
      }


      const deadline = new Date(json.reported_date);
      deadline.setDate(deadline.getDate() + 7);
      const modal = document.querySelector('#modal');
      const clsBtn = document.querySelector('#close-modal');
      const nvgBtn = document.querySelector('.navigate-btn');

      const now = new Date(Date.now())
      if (now.getDate() >= deadline.getDate()) {
        modal.classList.add('active');
      } else {
        modal.classList.remove('active');
      }

      clsBtn.addEventListener('click', () => {
        modal.classList.remove('active');
      })

      nvgBtn.addEventListener('click', () => {
        window.location.href = '/admin/pencatatan-jentik';
        modal.classList.remove('active');
      })

      timer(deadline);
    } catch (error) {
      console.log(error)
    }
  }

  getData()

  const modal = document.getElementById("myModal");
  modal.querySelector(".close").addEventListener("click", () => {
    modal.style.display = "none";
  });

</script>
@endif
