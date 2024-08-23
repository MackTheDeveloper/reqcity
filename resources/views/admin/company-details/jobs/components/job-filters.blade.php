<div class="filter-section-wrapper">
  <div class="filter-section">
    <div class="filter-data-wrapper">
      <div class="row" "filtercheckboxes">
        <div class="col-12 col-md-4 col-lg-3 col-xl-2">
          <div class="filter-column">
            <p class="tm">Category</p>
            <div class="ck-collapse-wrapper">
              <div class="ck-collapse">
                <label class="ck">All
                  <input type="checkbox" class="checkallparentCat"/>
                  <span class="ck-checkmark"></span>
                </label>
                @if(!empty($parentCategories) && count($parentCategories)>0)
                @foreach($parentCategories as $parentCategories)
                <label class="ck">{{ $parentCategories['name']}}
                  <input type="checkbox"  class="parent_cat" value="{{$parentCategories['id']}}" name="parent_cat[]"/>
                  <span class="ck-checkmark"></span>
                </label>
                @endforeach
                @endif

              </div>
            </div>
          </div>
        </div>
        <div class="col-12 col-md-4 col-lg-3 col-xl-2">
          <div class="filter-column">
            <p class="tm">Sub-Category</p>
            <div class="ck-collapse-wrapper">
              <div class="ck-collapse">
                <label class="ck">All
                  <input type="checkbox" class="checkallchildCat"/>
                  <span class="ck-checkmark"></span>
                </label>
                @if(!empty($childCategories) && count($childCategories)>0)
                @foreach($childCategories as $childCategories)
                <label class="ck">{{ $childCategories['name']}}
                  <input type="checkbox" class="child_cat" value="{{$childCategories['id']}}" name="child_cat[]"/>
                  <span class="ck-checkmark"></span>
                </label>

                @endforeach
                @endif
              </div>
            </div>
          </div>
        </div>
        
        @if(empty($status))
        <div class="col-12 col-md-4 col-lg-3 col-xl-2">
          <div class="filter-column">
            <p class="tm">Status</p>
            <div class="ck-collapse-wrapper">
              <div class="ck-collapse">
                <label class="ck">All
                  <input type="checkbox" class="checkallStatus"/>
                  <span class="ck-checkmark"></span>
                </label>
                <label class="ck">Open
                  <input type="checkbox" class="jobstatus" name="jobstatus[]" value="1"/>
                  <span class="ck-checkmark"></span>
                </label>
                <label class="ck">Paused
                  <input type="checkbox" class="jobstatus" name="jobstatus[]" value="3"/>
                  <span class="ck-checkmark"></span>
                </label>
                <label class="ck">Closed
                  <input type="checkbox" class="jobstatus" name="jobstatus[]" value="4"/>
                  <span class="ck-checkmark"></span>
                </label>
                <label class="ck">Draft
                  <input type="checkbox" class="jobstatus" name="jobstatus[]" value="2"/>
                  <span class="ck-checkmark"></span>
                </label>
              </div>
            </div>
          </div>
        </div>
        @endif
        <div class="col-12 col-md-4 col-lg-3 col-xl-2">
          <div class="filter-column">
            <p class="tm">Job Locations</p>
            <div class="ck-collapse-wrapper">
              <div class="ck-collapse">
                <label class="ck">All
                  <input type="checkbox" class="checkallJobLocation"/>
                  <span class="ck-checkmark"></span>
                </label>
                @if(!empty($jobLocations) && count($jobLocations)>0)
                @foreach($jobLocations as $key=>$value)
                <label class="ck">{{$value}}
                  <input type="checkbox" class="joblocation" value="{{$key}}" name="joblocation[]"/>
                  <span class="ck-checkmark"></span>
                </label>

                @endforeach
                @endif

              </div>
            </div>
          </div>
        </div>
        <div class="col-12 col-md-4 col-lg-3 col-xl-2">
          <div class="filter-column">
            <p class="tm">Job Type</p>
            <div class="ck-collapse-wrapper">
              <div class="ck-collapse">
                <label class="ck">All
                  <input type="checkbox" class="checkallEmpType"/>
                  <span class="ck-checkmark"></span>
                </label>
                @if(!empty($employmentType) && count($employmentType)>0)
                @foreach ($employmentType as $key => $row)
                <label class="ck">{{$row['value']}}
                  <input type="checkbox"  class="emp_type" value="{{$row['key']}}" name="emp_type[]"/>
                  <span class="ck-checkmark"></span>
                </label>

                @endforeach
                @endif
              </div>
            </div>
          </div>
        </div>
        <div class="col-12 col-md-4 col-lg-3 col-xl-2">
          <div class="filter-column">
            <p class="tm">Contract Type</p>
            <div class="ck-collapse-wrapper">
              <div class="ck-collapse">
                <label class="ck">All
                  <input type="checkbox" class="checkallConType"/>
                  <span class="ck-checkmark"></span>
                </label>
                @if(!empty($employmentType) && count($employmentType)>0)
                @foreach ($employmentType as $key => $row)
                <label class="ck">{{$row['value']}}
                  <input type="checkbox"  class="con_type" value="{{$row['key']}}" name="con_type[]"/>
                  <span class="ck-checkmark"></span>
                </label>

                @endforeach
                @endif
              </div>
            </div>
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
