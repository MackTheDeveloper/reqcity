<div class="filter-section-wrapper">
    <div class="filter-section">
        <div class="filter-sec-header">
            <div class="filter-name-close">
                <p class="tl">Filter</p>
                <img src="{{ asset('public/assets/frontend/img/x.svg') }}" class="close-filter" alt="" />
            </div>
            <div class="clear-apply">
                <button class="border-btn">Clear All</button>
                <button class="fill-btn">Apply</button>
            </div>
        </div>
        <div class="filter-data-wrapper">
            <div class="row" "filtercheckboxes">
                <div class="col-12 col-md-4 col-lg-3 col-xl-4">
                    {{-- <div class="filter-column">
                      <p class="tm">Category</p>
                      <div class="ck-collapse-wrapper">
                        <div class="ck-collapse">
                          <label class="ck">All
                            <input type="checkbox" class="checkallparentCat"/>
                            <span class="ck-checkmark"></span>
                          </label>
                          @if (!empty($parentCategories) && count($parentCategories) > 0)
                          @foreach ($parentCategories as $parentCategories)
                          <label class="ck">{{ $parentCategories['name']}}
                            <input type="checkbox"  class="parent_cat" value="{{$parentCategories['id']}}" name="parent_cat[]"/>
                            <span class="ck-checkmark"></span>
                          </label>
                          @endforeach
                          @endif

                        </div>
                      </div>
                    </div> --}}
                    <div class="input-groups filterDropDown">
                        <span>Category</span>
                        <div class="multi-select-dropdown">
                            <label class="multi-dropdown-label"></label>
                            <div class="multi-dropdown-list">
                                <label class="ck">All
                                    <input name="parent_cat[]" type="checkbox" class="ck check checkAllOption" checked>
                                    <span class="ck-checkmark" values="All"></span>
                                </label>
                                @if (!empty($parentCategories) && count($parentCategories) > 0)
                                    @foreach ($parentCategories as $key => $row)
                                        <label class="ck">{{ $row['name'] }}
                                            <input name="parent_cat[]" type="checkbox" class="ck check"
                                                value="{{ $row['id'] }}">
                                            <span class="ck-checkmark" values="{{ $row['name'] }}"></span>
                                        </label>
                                    @endforeach
                                @endif
                            </div>
                        </div>
                        <label id="schedule-error-container" class="error" for="job_schedule_ids[]"></label>
                    </div>
                </div>
                <div class="col-12 col-md-4 col-lg-3 col-xl-4">
                    {{-- <div class="filter-column">
                        <p class="tm">Sub-Category</p>
                        <div class="ck-collapse-wrapper">
                            <div class="ck-collapse">
                                <label class="ck">All
                                    <input type="checkbox" class="checkallchildCat" />
                                    <span class="ck-checkmark"></span>
                                </label>
                                @if (!empty($childCategories) && count($childCategories) > 0)
                                    @foreach ($childCategories as $childCategories)
                                        <label class="ck">{{ $childCategories['name'] }}
                                            <input type="checkbox" class="child_cat"
                                                value="{{ $childCategories['id'] }}" name="child_cat[]" />
                                            <span class="ck-checkmark"></span>
                                        </label>
                                    @endforeach
                                @endif
                            </div>
                        </div>
                    </div> --}}
                    <div class="input-groups filterDropDown">
                        <span>Sub-Category</span>
                        <div class="multi-select-dropdown">
                            <label class="multi-dropdown-label"></label>
                            <div class="multi-dropdown-list">
                                <label class="ck">All
                                    <input name="child_cat[]" type="checkbox" class="ck check checkAllOption" checked>
                                    <span class="ck-checkmark" values="All"></span>
                                </label>
                                @if (!empty($childCategories) && count($childCategories) > 0)
                                    @foreach ($childCategories as $key => $row)
                                        <label class="ck">{{ $row['name'] }}
                                            <input name="child_cat[]" type="checkbox" class="ck check"
                                                value="{{ $row['id'] }}">
                                            <span class="ck-checkmark" values="{{ $row['name'] }}"></span>
                                        </label>
                                    @endforeach
                                @endif
                            </div>
                        </div>
                        <label id="schedule-error-container" class="error" for="job_schedule_ids[]"></label>
                    </div>
                </div>
                @if (!empty($jobStatus))
                    <div class="col-12 col-md-4 col-lg-3 col-xl-4">
                        {{-- <div class="filter-column">
                            <p class="tm">Status</p>
                            <div class="ck-collapse-wrapper">
                                <div class="ck-collapse">
                                    <label class="ck">All
                                        <input type="checkbox" class="checkallStatus" />
                                        <span class="ck-checkmark"></span>
                                    </label>
                                    <label class="ck">Open
                                        <input type="checkbox" class="jobstatus" name="jobstatus[]" value="1" />
                                        <span class="ck-checkmark"></span>
                                    </label>
                                    <label class="ck">Paused
                                        <input type="checkbox" class="jobstatus" name="jobstatus[]" value="3" />
                                        <span class="ck-checkmark"></span>
                                    </label>
                                    <label class="ck">Closed
                                        <input type="checkbox" class="jobstatus" name="jobstatus[]" value="4" />
                                        <span class="ck-checkmark"></span>
                                    </label>
                                    <label class="ck">Draft
                                        <input type="checkbox" class="jobstatus" name="jobstatus[]" value="2" />
                                        <span class="ck-checkmark"></span>
                                    </label>
                                </div>
                            </div>
                        </div> --}}
                        <div class="input-groups filterDropDown">
                            <span>Status</span>
                            <div class="multi-select-dropdown">
                                <label class="multi-dropdown-label"></label>
                                <div class="multi-dropdown-list">
                                    <label class="ck">All
                                        <input name="jobstatus[]" type="checkbox" class="ck check checkAllOption" checked>
                                        <span class="ck-checkmark" values="All"></span>
                                    </label>
                                    @if (!empty($jobStatus) && count($jobStatus) > 0)
                                        @foreach ($jobStatus as $key => $row)
                                            <label class="ck">{{ $row }}
                                                <input name="jobstatus[]" type="checkbox" class="ck check"
                                                    value="{{ $key }}">
                                                <span class="ck-checkmark" values="{{ $row }}"></span>
                                            </label>
                                        @endforeach
                                    @endif
                                </div>
                            </div>
                            <label id="schedule-error-container" class="error"
                                for="job_schedule_ids[]"></label>
                        </div>
                    </div>
                @endif
                <div class="col-12 col-md-4 col-lg-3 col-xl-4">
                    {{-- <div class="filter-column">
                        <p class="tm">Job Locations</p>
                        <div class="ck-collapse-wrapper">
                            <div class="ck-collapse">
                                <label class="ck">All
                                    <input type="checkbox" class="checkallJobLocation" />
                                    <span class="ck-checkmark"></span>
                                </label>
                                @if (!empty($jobLocations) && count($jobLocations) > 0)
                                    @foreach ($jobLocations as $key => $value)
                                        <label class="ck">{{ $value }}
                                            <input type="checkbox" class="joblocation" value="{{ $key }}"
                                                name="joblocation[]" />
                                            <span class="ck-checkmark"></span>
                                        </label>
                                    @endforeach
                                @endif

                            </div>
                        </div>
                    </div> --}}

                    <div class="input-groups filterDropDown">
                        <span>Job Locations</span>
                        <div class="multi-select-dropdown">
                            <label class="multi-dropdown-label"></label>
                            <div class="multi-dropdown-list">
                                <label class="ck">All
                                    <input name="joblocation[]" type="checkbox" class="ck check checkAllOption" checked>
                                    <span class="ck-checkmark" values="All"></span>
                                </label>
                                @if (!empty($jobLocations) && count($jobLocations) > 0)
                                    @foreach ($jobLocations as $key => $row)
                                        <label class="ck">{{ $row }}
                                            <input name="joblocation[]" type="checkbox" class="ck check"
                                                value="{{ $key }}">
                                            <span class="ck-checkmark" values="{{ $row }}"></span>
                                        </label>
                                    @endforeach
                                @endif
                            </div>
                        </div>
                        <label id="schedule-error-container" class="error" for="job_schedule_ids[]"></label>
                    </div>
                </div>
                <div class="col-12 col-md-4 col-lg-3 col-xl-4">
                    {{-- <div class="filter-column">
                        <p class="tm">Job Type</p>
                        <div class="ck-collapse-wrapper">
                            <div class="ck-collapse">
                                <label class="ck">All
                                    <input type="checkbox" class="checkallEmpType" />
                                    <span class="ck-checkmark"></span>
                                </label>
                                @if (!empty($employmentType) && count($employmentType) > 0)
                                    @foreach ($employmentType as $key => $row)
                                        <label class="ck">{{ $row['value'] }}
                                            <input type="checkbox" class="emp_type" value="{{ $row['key'] }}"
                                                name="emp_type[]" />
                                            <span class="ck-checkmark"></span>
                                        </label>
                                    @endforeach
                                @endif
                            </div>
                        </div>
                    </div> --}}
                    <div class="input-groups filterDropDown">
                        <span>Job Type</span>
                        <div class="multi-select-dropdown">
                            <label class="multi-dropdown-label"></label>
                            <div class="multi-dropdown-list">
                                <label class="ck">All
                                    <input name="emp_type[]" type="checkbox" class="ck check checkAllOption" checked>
                                    <span class="ck-checkmark" values="All"></span>
                                </label>
                                @if (!empty($employmentType) && count($employmentType) > 0)
                                    @foreach ($employmentType as $key => $row)
                                        <label class="ck">{{ $row['value'] }}
                                            <input name="emp_type[]" type="checkbox" class="ck check"
                                                value="{{ $row['key'] }}">
                                            <span class="ck-checkmark" values="{{ $row['value'] }}"></span>
                                        </label>
                                    @endforeach
                                @endif
                            </div>
                        </div>
                        <label id="schedule-error-container" class="error" for="job_schedule_ids[]"></label>
                    </div>
                </div>
                <div class="col-12 col-md-4 col-lg-3 col-xl-4">
                    {{-- <div class="filter-column">
                        <p class="tm">Contract Type</p>
                        <div class="ck-collapse-wrapper">
                            <div class="ck-collapse">
                                <label class="ck">All
                                    <input type="checkbox" class="checkallConType" />
                                    <span class="ck-checkmark"></span>
                                </label>
                                @if (!empty($employmentType) && count($employmentType) > 0)
                                    @foreach ($employmentType as $key => $row)
                                        <label class="ck">{{ $row['value'] }}
                                            <input type="checkbox" class="con_type" value="{{ $row['key'] }}"
                                                name="con_type[]" />
                                            <span class="ck-checkmark"></span>
                                        </label>
                                    @endforeach
                                @endif
                            </div>
                        </div>
                    </div> --}}
                    <div class="input-groups filterDropDown">
                        <span>Contract Type</span>
                        <div class="multi-select-dropdown">
                            <label class="multi-dropdown-label"></label>
                            <div class="multi-dropdown-list">
                                <label class="ck">All
                                    <input name="con_type[]" type="checkbox" class="ck check checkAllOption" checked>
                                    <span class="ck-checkmark" values="All"></span>
                                </label>
                                @if (!empty($contractType) && count($contractType) > 0)
                                    @foreach ($contractType as $key => $row)
                                        <label class="ck">{{ $row['value'] }}
                                            <input name="con_type[]" type="checkbox" class="ck check"
                                                value="{{ $row['key'] }}">
                                            <span class="ck-checkmark" values="{{ $row['value'] }}"></span>
                                        </label>
                                    @endforeach
                                @endif
                            </div>
                        </div>
                        <label id="schedule-error-container" class="error" for="job_schedule_ids[]"></label>
                    </div>
                </div>
                <div class="col-12 text-right job-filter-btn">
                    <button class="border-btn clearFilterJob">Clear All</button>
                    <button class="fill-btn filterJob">Apply</button>
                </div>
            </div>
        </div>
    </div>
</div>
