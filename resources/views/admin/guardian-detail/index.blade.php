<div class="row">
  <div class="col-md-12">
    <fieldset class="row scheduler-border">
        <div class="d-flex justify-content-between">
          <div>
            <legend>{{ __('field_guardians_information') }}</legend>
          </div>
          <div>
              <a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#createGuardianModal-{{ $student->id }}" type="button" class="btn btn-info mb-2"><i class="fas fa-plus"></i> {{ __('btn_add_new') }}</a>
          </div>
        </div>
        <!-- [ Data table ] start -->
        <div class="table-responsive">
          <table id="table" class="display table nowrap table-striped table-hover" style="width:100%">
              <thead>
                  <tr>
                      <th>#</th>
                      <th>{{ __('field_relation') }}</th>
                      <th>Name</th>
                      <th>Email</th>
                      <th>Occupation</th>
                      <th>Annual Income</th>
                      <th>Phone</th>
                      <th>Action</th>
                  </tr>
              </thead>
              <tbody>
                  @foreach( $guardian_details as $key => $guardian_detail )
                  <tr>
                      <td>{{ $key + 1 }}</td>
                      <td>{{ @$guardian_detail->relation->name }}</td>
                      <td>{{ @$guardian_detail->email ?? '-' }}</td>
                      <td>
                        {{ @$guardian_detail->name }}
                      </td>
                      <td>
                        {{ @$guardian_detail->occupation }}
                      </td>
                      <td>
                        @if(@$guardian_detail->annual_income == 1)
                          {{ __('Below 1 Lac') }}
                        @elseif(@$guardian_detail->annual_income == 2)
                          {{ __('1 - 3 Lacs') }}
                        @elseif(@$guardian_detail->annual_income == 3)
                          {{ __('3 -5 Lacs') }}
                        @elseif(@$guardian_detail->annual_income == 4)
                          {{ __('5 - 8 Lacs') }}
                        @elseif(@$guardian_detail->annual_income == 5)
                          {{ __('8 - 10 Lacs') }}
                        @elseif(@$guardian_detail->annual_income == 6)
                          {{ __('10 - 15 Lacs') }}
                        @elseif(@$guardian_detail->annual_income == 6)
                          {{ __('More than 15 Lacs') }}
                        @elseif(@$guardian_detail->annual_income == 7)
                          {{ __('More than 15 Lacs') }}
                        @else
                          {{@$guardian_detail->annual_income}}
                        @endif
                      </td>
                      <td>
                        {{ @$guardian_detail->phone }}
                      </td>
                      <td>
                        <button type="button" class="btn btn-icon btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#editGuardianModal-{{ @$guardian_detail->id }}"><i class="fas fa-edit"></i>
                        </button>
                        @include('admin.guardian-detail.edit')
                        <button type="button" class="btn btn-icon btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deleteGuardianModal-{{ @$guardian_detail->id }}">
                          <i class="fas fa-trash-alt"></i>
                        </button>
                        @include('admin.guardian-detail.delete')
                      </td>
                  </tr>
                  @endforeach
              </tbody>
          </table>
        </div>
        <!-- [ Data table ] end -->
    </fieldset>
  </div>
</div>
@include('admin.guardian-detail.create')
