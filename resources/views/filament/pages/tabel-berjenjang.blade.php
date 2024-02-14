<x-filament-panels::page>
  <div class="grid md:grid-cols-2 gap-4">
    <div class="relative overflow-x-auto">
      <div class="bg-orange-400 p-2 rounded-t-lg">
        <h4 class="text-sm font-semibold">Tabel Berjenjang Kasus DBD</h4>
      </div>
      <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
          @if(auth()->user()->modelHasRole[0]->role->name == "super_admin" || auth()->user()->modelHasRole[0]->role->name == 'dinas')
          <tr>
            <th scope="col" class="px-6 py-3">
              Kecamatan
            </th>
            <th scope="col" class="px-6 py-3">
              Kelurahan
            </th>
            <th scope="col" class="px-6 py-3">
              RW
            </th>
          </tr>
          @else
          <tr>
            <th scope="col" class="px-6 py-3">
              Kelurahan

            </th>
            <th scope="col" class="px-6 py-3">
              RW
            </th>
          </tr>

          @endif
        </thead>
        <tbody>
          @if(auth()->user()->modelHasRole[0]->role->name == "super_admin" || auth()->user()->modelHasRole[0]->role->name == 'dinas')
          @foreach($this->getDataDbd() as $data)
          <tr onclick="window.location='{{ url('admin/pencatatan-kasus-dbds?tableFilters[master_kecamatan_id][value]=' . $data->kecamatan->id . '&tableFilters[master_kelurahan_id][value]=' . $data->kelurahan->id .'') }}'" class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 cursor-pointer">
            <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
              {{ $data->kecamatan->nama }}
            </th>
            <td class="px-6 py-4">
              {{ $data->kelurahan->nama }}
            </td>
            <td class="px-6 py-4">
              {{ $data->rw }} ({{ $data['count'] }})
            </td>
          </tr>
          @endforeach
          @else
          @foreach($this->getDataDbd() as $data)
          <tr onclick="window.location='{{ url('admin/pencatatan-kasus-dbds?tableFilters[master_kelurahan_id][value]=' . $data->kelurahan->id .'') }}'" class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 cursor-pointer">
            <td class="px-6 py-4">
              {{ $data->kelurahan->nama }}
            </td>
            <td class="px-6 py-4">
              {{ $data->rw }} ({{ $data['count'] }})
            </td>
          </tr>
          @endforeach
          @endif
        </tbody>
      </table>
    </div>
    <div class="relative overflow-x-auto">
      <div class="bg-orange-400 p-2 rounded-t-lg">
        <h4 class="text-sm font-semibold">Tabel Berjenjang Pencatatan Jentik</h4>
      </div>
      <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
          @if(auth()->user()->modelHasRole[0]->role->name == "super_admin" || auth()->user()->modelHasRole[0]->role->name == 'dinas')
          <tr>
            <th scope="col" class="px-6 py-3">
              Kecamatan

            </th>
            <th scope="col" class="px-6 py-3">
              Kelurahan

            </th>
            <th scope="col" class="px-6 py-3">
              RW
            </th>
          </tr>
          @else
          <th scope="col" class="px-6 py-3">
            Kelurahan

          </th>
          <th scope="col" class="px-6 py-3">
            RW
          </th>
          </tr>
          @endif
        </thead>
        <tbody>
          @if(auth()->user()->modelHasRole[0]->role->name == "super_admin" || auth()->user()->modelHasRole[0]->role->name == 'dinas')
          @foreach($this->getDataDbd() as $data)
          <tr onclick="window.location='{{ url('admin/pencatatan-jentiks?tableFilters[master_kecamatan_id][value]=' . $data->kecamatan->id . '&tableFilters[master_kelurahan_id][value]=' . $data->kelurahan->id .'') }}'" class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 cursor-pointer">
            <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
              {{ $data->kecamatan->nama }}
            </th>
            <td class="px-6 py-4">
              {{ $data->kelurahan->nama }}
            </td>
            <td class="px-6 py-4">
              {{ $data->rw }} ({{ $data['count'] }})
            </td>
          </tr>
          @endforeach
          @else
          @foreach($this->getDataDbd() as $data)
          <tr onclick="window.location='{{ url('admin/pencatatan-jentiks?tableFilters[master_kelurahan_id][value]=' . $data->kelurahan->id .'') }}'" class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 cursor-pointer">
            <td class="px-6 py-4">
              {{ $data->kelurahan->nama }}
            </td>
            <td class="px-6 py-4">
              {{ $data->rw }} ({{ $data['count'] }})
            </td>
          </tr>
          @endforeach
          @endif

        </tbody>
      </table>
    </div>
  </div>
</x-filament-panels::page>
