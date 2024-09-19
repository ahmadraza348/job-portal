@extends('front.layouts.app')
@section('main')
    <section class="section-5 bg-2">
        <div class="container py-5">
            <div class="row">
                <div class="col">
                    <nav aria-label="breadcrumb" class=" rounded-3 p-3 mb-4">
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">Account Settings</li>
                        </ol>
                    </nav>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-3">
                    @include('front.account.sidebar')
                </div>
                <div class="col-lg-9">

                    <form action="" method="post" id="editJobForm" name="editJobForm">

                        <div class="card border-0 shadow mb-4 ">
                            @include('front.message')

                            <div class="card-body card-form p-4">
                                <h3 class="fs-4 mb-1">Update Job Details</h3>
                                <div class="row">
                                    <div class="col-md-6 mb-4">
                                        <label for="" class="mb-2">Title<span class="req">*</span></label>
                                        <input type="text" placeholder="Job Title"
                                            id="title"value="{{ $job->title }}" name="title" class="form-control">
                                        <p></p>
                                    </div>
                                    <div class="col-md-6  mb-4">
                                        <label for="" class="mb-2">Category<span class="req">*</span></label>
                                        <select name="category" id="category" class="form-control">
                                            <option value="">Select a Category</option>
                                            @if ($categories->isNotEmpty())
                                                @foreach ($categories as $item)
                                                    <option {{ $job->category_id == $item->id ? 'selected' : '' }}
                                                        value="{{ $item->id }}">{{ $item->name }}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                        <p></p>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 mb-4">
                                        <label for="" class="mb-2">Job Nature<span class="req">*</span></label>
                                        <select class="form-select"name="jobType" id="jobType">
                                            @if ($jobTypes->isNotEmpty())
                                                <option value="">Select Type</option>
                                                @foreach ($jobTypes as $item)
                                                    <option {{ $job->job_type_id == $item->id ? 'selected' : '' }}
                                                        value="{{ $item->id }}">{{ $item->name }}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                        <p></p>
                                    </div>
                                    <div class="col-md-6  mb-4">
                                        <label for="" class="mb-2">Vacancy<span class="req">*</span></label>
                                        <input type="number" min="1"value="{{ $job->vacancy }}"
                                            placeholder="Vacancy" id="vacancy" name="vacancy" class="form-control">
                                        <p></p>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="mb-4 col-md-6">
                                        <label for="" class="mb-2">Salary</label>
                                        <input type="text"value="{{ $job->salary }}" placeholder="Salary" id="salary"
                                            name="salary" class="form-control">
                                    </div>

                                    <div class="mb-4 col-md-6">
                                        <label for="" class="mb-2">Location<span class="req">*</span></label>
                                        <input type="text"value="{{ $job->location }}" placeholder="location"
                                            id="location" name="location" class="form-control">
                                        <p></p>
                                    </div>
                                </div>

                                <div class="mb-4">
                                    <label for="" class="mb-2">Description<span class="req">*</span></label>
                                    <textarea class="form-control" name="description" id="description" cols="5" rows="5"
                                        placeholder="Description">{{ $job->description }}"</textarea>
                                    <p></p>
                                </div>
                                <div class="mb-4">
                                    <label for="" class="mb-2">Benefits</label>
                                    <textarea class="form-control" value="" name="benefits" id="benefits" cols="5" rows="5"
                                        placeholder="Benefits">{{ $job->benefits }}</textarea>
                                </div>
                                <div class="mb-4">
                                    <label for="" class="mb-2">Responsibility</label>
                                    <textarea class="form-control" name="responsibility" id="responsibility" cols="5" rows="5"
                                        placeholder="Responsibility">{{ $job->responsibility }}</textarea>
                                </div>
                                <div class="mb-4">
                                    <label for="" class="mb-2">Qualifications</label>
                                    <textarea class="form-control" name="qualifications" id="qualifications" cols="5" rows="5"
                                        placeholder="Qualifications">{{ $job->qualifications }}</textarea>
                                </div>

                                <div class="col-md-6 mb-4">
                                    <label for="" class="mb-2">Experience <span class="req">*</span></label>
                                    <select class="form-select"name="experience" id="experience">
                                        <option value="1"{{ $job->experience == 1 ? 'selected' : '' }}>1 Year
                                        </option>
                                        <option value="2"{{ $job->experience == 2 ? 'selected' : '' }}>2 Year
                                        </option>
                                        <option value="3"{{ $job->experience == 3 ? 'selected' : '' }}>3 Year
                                        </option>
                                        <option value="4"{{ $job->experience == 4 ? 'selected' : '' }}>4 Year
                                        </option>
                                        <option value="5"{{ $job->experience == 5 ? 'selected' : '' }}>5 Year
                                        </option>
                                        <option value="6"{{ $job->experience == 6 ? 'selected' : '' }}>6 Year
                                        </option>
                                        <option value="7"{{ $job->experience == 7 ? 'selected' : '' }}>7 Year
                                        </option>
                                        <option value="8"{{ $job->experience == 8 ? 'selected' : '' }}>8 Year
                                        </option>
                                        <option value="9"{{ $job->experience == 9 ? 'selected' : '' }}>9 Year
                                        </option>
                                        <option value="10"{{ $job->experience == 10 ? 'selected' : '' }}>10 Year
                                        </option>
                                        <option value="10_plus"{{ $job->experience == '10_plus' ? 'selected' : '' }}>10+
                                            Years</option>
                                    </select>

                                    <p></p>
                                </div>



                                <div class="mb-4">
                                    <label for="" class="mb-2">Keywords</label>
                                    <input type="text" placeholder="keywords"value="{{ $job->keywords }}"
                                        id="keywords" name="keywords" class="form-control">
                                </div>

                                <h3 class="fs-4 mb-1 mt-5 border-top pt-5">Company Details</h3>

                                <div class="row">
                                    <div class="mb-4 col-md-6">
                                        <label for="" class="mb-2">Name<span class="req">*</span></label>
                                        <input type="text"value="{{ $job->company_name }}" placeholder="Company Name"
                                            id="company_name" name="company_name" class="form-control">
                                        <p></p>
                                    </div>

                                    <div class="mb-4 col-md-6">
                                        <label for="" class="mb-2">Location</label>
                                        <input type="text"value="{{ $job->company_location }}" placeholder="Location"
                                            id="location" name="company_location" class="form-control">
                                    </div>
                                </div>

                                <div class="mb-4">
                                    <label for="" class="mb-2">Website</label>
                                    <input type="url"value="{{ $job->company_website }}" placeholder="Website"
                                        id="website" name="company_website" class="form-control">
                                </div>
                            </div>
                            <div class="card-footer  p-4">
                                <button type="submit" class="btn btn-primary">Update Job</button>
                            </div>
                        </div>

                    </form>

                </div>
            </div>
    </section>
@endsection


@section('customJs')
    <script>
        $(document).ready(function() {
            $("#editJobForm").submit(function(e) {
                e.preventDefault();
                // $("button[type='submit']").prop(disabled, true);
                $.ajax({
                    url: '{{ route('account.updateJob',$job->id) }}',
                    type: 'post',
                    data: $("#editJobForm").serializeArray(),
                    dataType: "json",
                    success: function(response) {
                        // $("button[type='submit']").prop(disabled, true);
                        if (response.status === false) {
                            var errors = response.errors;

                            // Name Field
                            if (errors.title) {
                                $("#title").addClass('is-invalid')
                                    .siblings('p')
                                    .addClass('invalid-feedback')
                                    .html(errors.title);
                            } else {
                                $("#title").removeClass('is-invalid')
                                    .siblings('p')
                                    .removeClass('invalid-feedback')
                                    .html('');
                            }

                            // Category Field
                            if (errors.category) {
                                $("#category").addClass('is-invalid')
                                    .siblings('p')
                                    .addClass('invalid-feedback')
                                    .html(errors.category);
                            } else {
                                $("#category").removeClass('is-invalid')
                                    .siblings('p')
                                    .removeClass('invalid-feedback')
                                    .html('');
                            }
                            // jobType Field
                            if (errors.jobType) {
                                $("#jobType").addClass('is-invalid')
                                    .siblings('p')
                                    .addClass('invalid-feedback')
                                    .html(errors.jobType);
                            } else {
                                $("#jobType").removeClass('is-invalid')
                                    .siblings('p')
                                    .removeClass('invalid-feedback')
                                    .html('');
                            }
                            // vacancy Field
                            if (errors.vacancy) {
                                $("#vacancy").addClass('is-invalid')
                                    .siblings('p')
                                    .addClass('invalid-feedback')
                                    .html(errors.vacancy);
                            } else {
                                $("#vacancy").removeClass('is-invalid')
                                    .siblings('p')
                                    .removeClass('invalid-feedback')
                                    .html('');
                            }
                            // location Field
                            if (errors.location) {
                                $("#location").addClass('is-invalid')
                                    .siblings('p')
                                    .addClass('invalid-feedback')
                                    .html(errors.location);
                            } else {
                                $("#location").removeClass('is-invalid')
                                    .siblings('p')
                                    .removeClass('invalid-feedback')
                                    .html('');
                            }
                            // description Field
                            if (errors.description) {
                                $("#description").addClass('is-invalid')
                                    .siblings('p')
                                    .addClass('invalid-feedback')
                                    .html(errors.description);
                            } else {
                                $("#description").removeClass('is-invalid')
                                    .siblings('p')
                                    .removeClass('invalid-feedback')
                                    .html('');
                            }
                            // experience Field
                            if (errors.experience) {
                                $("#experience").addClass('is-invalid')
                                    .siblings('p')
                                    .addClass('invalid-feedback')
                                    .html(errors.experience);
                            } else {
                                $("#experience").removeClass('is-invalid')
                                    .siblings('p')
                                    .removeClass('invalid-feedback')
                                    .html('');
                            }
                            // company_name Field
                            if (errors.company_name) {
                                $("#company_name").addClass('is-invalid')
                                    .siblings('p')
                                    .addClass('invalid-feedback')
                                    .html(errors.company_name);
                            } else {
                                $("#company_name").removeClass('is-invalid')
                                    .siblings('p')
                                    .removeClass('invalid-feedback')
                                    .html('');
                            }
                        } else {
                            // Clear all fields when no errors exist
                            $("#title,#category, #jobType, #vacancy, #location, #description, #company_name")
                                .removeClass('is-invalid')
                                .siblings('p')
                                .removeClass('invalid-feedback')
                                .html('');
                            window.location.href = '{{ route('account.myJobs') }}';

                        }
                    }
                });
            });
        });
    </script>
@endsection
