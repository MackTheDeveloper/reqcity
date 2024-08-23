<div class="section_branch" id="section_branch_{{ $countAddresses }}">
    <a href="javascript:void(0)" class="close-section" data-id="{{ $countAddresses }}">
        <img src="{{ asset('public/assets/frontend/img/close.svg') }}" alt="" />
    </a>
    <div class="row" id="cmp_address-{{ $countAddresses }}">
        
        <div class="col-12 col-sm-6 col-md-6">
            <div class="input-groups">
                <span>Address</span>
                <input type="text" name="company_address[{{ $countAddresses }}][address_1]"
                    id="company_address_address_1-{{ $countAddresses }}" value="" />
            </div>
        </div>
        <div class="col-12 col-sm-6 col-md-6">
            <div class="input-groups">
                <span>City</span>
                <input type="text" name="company_address[{{ $countAddresses }}][city]"
                    id="company_address_city-{{ $countAddresses }}" value="" />
            </div>
        </div>
        <div class="col-12 col-sm-6 col-md-6">
            <div class="input-groups">
                <span>State</span>
                <input type="text" name="company_address[{{ $countAddresses }}][address_2]"
                    id="company_address_address_2-{{ $countAddresses }}" value="" />
            </div>
        </div>
        <div class="col-12 col-sm-6 col-md-6">
            <div class="input-groups">
                <span>Zip code</span>
                <input type="text" name="company_address[{{ $countAddresses }}][postcode]"
                    id="company_address_postcode-{{ $countAddresses }}" value="" />
            </div>
        </div>
        <div class="col-12 col-sm-6 col-md-6">
            <div class="input-groups">
                <span>Country</span>
                <select name="company_address[{{ $countAddresses }}][country]"
                    id="company_address_country-{{ $countAddresses }}">
                    @foreach ($countries as $key => $row)
                        <option value="{{ $row['key'] }}" {{ $row['value'] == 'United States' ? 'selected' : '' }}>
                            {{ $row['value'] }}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>
</div>
