document.addEventListener('DOMContentLoaded', function() {
    const countrySelect = document.getElementById('country');
    const stateSelect = document.getElementById('state');
    const citySelect = document.getElementById('city');
    const countryCodeSelect = document.getElementById('country_code');

    const config = {
        cUrl: 'https://api.countrystatecity.in/v1/countries',
        ckey: 'NHhvOEcyWk50N2Vna3VFTE00bFp3MjFKR0ZEOUhkZlg4RTk1MlJlaA=='
    }

    function loadCountries() {
        let apiEndPoint = config.cUrl

        fetch(apiEndPoint, { headers: { "X-CSCAPI-KEY": config.ckey } })
            .then(response => response.json())
            .then(data => {
                data.forEach(country => {
                    const option = document.createElement('option')
                    option.value = country.iso2
                    option.textContent = country.name
                    countrySelect.appendChild(option)

                    // Also populate country codes
                    const codeOption = document.createElement('option')
                    codeOption.value = country.iso2
                    codeOption.textContent = `${country.name} (+${country.phonecode})`
                    countryCodeSelect.appendChild(codeOption)
                })
            })
            .catch(error => console.error('Error loading countries:', error))

        stateSelect.disabled = true
        citySelect.disabled = true
    }

    function loadStates() {
        stateSelect.disabled = false
        citySelect.disabled = true

        const selectedCountryCode = countrySelect.value
        stateSelect.innerHTML = '<option value="">Select State</option>' // for clearing the existing states
        citySelect.innerHTML = '<option value="">Select City</option>' // Clear existing city options

        fetch(`${config.cUrl}/${selectedCountryCode}/states`, { headers: { "X-CSCAPI-KEY": config.ckey } })
            .then(response => response.json())
            .then(data => {
                data.forEach(state => {
                    const option = document.createElement('option')
                    option.value = state.iso2
                    option.textContent = state.name
                    stateSelect.appendChild(option)
                })
            })
            .catch(error => console.error('Error loading states:', error))
    }

    function loadCities() {
        citySelect.disabled = false

        const selectedCountryCode = countrySelect.value
        const selectedStateCode = stateSelect.value
        citySelect.innerHTML = '<option value="">Select City</option>' // Clear existing city options

        fetch(`${config.cUrl}/${selectedCountryCode}/states/${selectedStateCode}/cities`, { headers: { "X-CSCAPI-KEY": config.ckey } })
            .then(response => response.json())
            .then(data => {
                data.forEach(city => {
                    const option = document.createElement('option')
                    option.value = city.iso2
                    option.textContent = city.name
                    citySelect.appendChild(option)
                })
            })
            .catch(error => console.error('Error loading cities:', error))
    }

    countrySelect.addEventListener('change', loadStates)
    stateSelect.addEventListener('change', loadCities)

    loadCountries()
});
