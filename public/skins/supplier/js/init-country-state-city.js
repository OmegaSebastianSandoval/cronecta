document.addEventListener('DOMContentLoaded', () => {
  const countriesData = window.countriesData;

  function initCountryStateCity({
    countryId,
    stateId,
    cityId,
    stateWrapperId,
    cityWrapperId
  }) {
    const countryEl = document.getElementById(countryId);
    const stateEl = document.getElementById(stateId);
    const cityEl = document.getElementById(cityId);
    const sw = document.getElementById(stateWrapperId);
    const cw = document.getElementById(cityWrapperId);

    const colombiaName = countriesData.find(c => c.name.toLowerCase() === 'colombia')?.name;

    countryEl.addEventListener('change', () => {
      const sel = countryEl.value;
      stateEl.innerHTML = '<option value="">Seleccione...</option>';
      cityEl.innerHTML = '<option value="">Seleccione...</option>';
      sw.classList.add('d-none');
      cw.classList.add('d-none');

      if (sel === colombiaName) {
        const country = countriesData.find(c => c.name === sel);
        country.states?.forEach(s => stateEl.appendChild(new Option(s.name, s.name)));
        sw.classList.remove('d-none');
      }
    });

    stateEl.addEventListener('change', () => {
      const cvalue = countryEl.value;
      const svalue = stateEl.value;
      cityEl.innerHTML = '<option value="">Seleccione...</option>';
      cw.classList.add('d-none');

      if (cvalue === colombiaName && svalue) {
        const country = countriesData.find(c => c.name === cvalue);
        const state = country.states.find(s => s.name === svalue);
        state.cities?.forEach(ct => cityEl.appendChild(new Option(ct.name, ct.name)));
        cw.classList.remove('d-none');
      }
    });

    const selCountry = decodeHtml(window.prefillCountry);
    const selState = decodeHtml(window.prefillState);
    const selCity = decodeHtml(window.prefillCity);

    if (selCountry === colombiaName) {
      const country = countriesData.find(c => c.name === selCountry);
      stateEl.innerHTML = '<option value="">Seleccione...</option>';
      country.states?.forEach(s => stateEl.appendChild(new Option(s.name, s.name)));
      sw.classList.remove('d-none');
      stateEl.value = selState;

      const selectedState = country.states.find(s => s.name === selState);
      if (selectedState) {
        cityEl.innerHTML = '<option value="">Seleccione...</option>';
        selectedState.cities?.forEach(ct => cityEl.appendChild(new Option(ct.name, ct.name)));
        cw.classList.remove('d-none');
        cityEl.value = selCity;
      }
    }
  }

  function decodeHtml(html) {
    const parser = new DOMParser();
    const doc = parser.parseFromString(html, 'text/html');
    return doc.documentElement.textContent;
  }

  initCountryStateCity({
    countryId: 'country',
    stateId: 'state',
    cityId: 'city',
    stateWrapperId: 'state-wrapper',
    cityWrapperId: 'city-wrapper'
  });
});
