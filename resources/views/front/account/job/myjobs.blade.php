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

                    <form action=""method="post" id="createJobForm" name="createJobForm">

                        <div class="card border-0 shadow mb-4 ">
                            @include('front.message')

                            <div class="card-body card-form">
                                <div class="d-flex justify-content-between">
                                    <div>
                                        <h3 class="fs-4 mb-1">My Jobs</h3>
                                    </div>
                                    <div style="margin-top: -10px;">
                                        <a href="{{route('account.createJob')}}" class="btn btn-primary">Post a Job</a>
                                    </div>

                                </div>
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead class="bg-light">
                                            <tr>
                                                <th scope="col">Title</th>
                                                <th scope="col">Job Created</th>
                                                <th scope="col">Applicants</th>
                                                <th scope="col">Status</th>
                                                <th scope="col">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody class="border-0">
                                            @if ($jobs->isNotEmpty())
                                                @foreach ($jobs as $item)
                                                    <tr class="active">
                                                        <td>
                                                            <div class="job-name fw-500">{{ $item->title }}</div>
                                                            <div class="info1">{{$item->jobType->name}} . {{ $item->location }}</div>
                                                        </td>
                                                        <td>{{ \Carbon\Carbon::parse($item->created_at)->format('d M, Y') }}</td>
                                                        <td>0 Applications</td>
                                                        <td>
                                                            @if ($item->status == 1)
                                                                <div class="job-status text-capitalize">Active</div>
                                                            @else
                                                                <div class="job-status text-capitalize">Block</div>
                                                            @endif
                                                        </td>
                                                        <td>
                                                            <div class="action-dots float-end">
                                                                <a href="#" class="" data-bs-toggle="dropdown" aria-expanded="false">
                                                                    <i class="fa fa-ellipsis-v" aria-hidden="true"></i>
                                                                </a>
                                                                <ul class="dropdown-menu dropdown-menu-end">
                                                                    <li><a class="dropdown-item" href="job-detail.html"> 
                                                                        <i class="fa fa-eye" aria-hidden="true"></i> View</a></li>
                                                                    <li><a class="dropdown-item" href="{{route('account.editJob', $item->id)}}">
                                                                        <i class="fa fa-edit" aria-hidden="true"></i> Edit</a></li>
                                                                    <li><a class="dropdown-item" href="#">
                                                                        <i class="fa fa-trash" aria-hidden="true"></i> Remove</a></li>
                                                                </ul>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            @else
                                                <tr>
                                                    <td colspan="5" class="text-center">No Job Posted</td>
                                                </tr>
                                            @endif
                                        </tbody>
                                    </table>
                                </div>

                                <div>
                                    {{$jobs->links()}}
                                </div>
                                
                            </div>
                        </div>

                    </form>

                </div>
            </div>
    </section>
@endsection


@section('customJs')
    <script>
        $("#createJobForm").submit(function(e) {
            e.preventDefault();

            $.ajax({
                url: '{{ route('account.saveJob') }}',
                type: 'post',
                data: $("#createJobForm").serializeArray(),
                dataType: "json",
                success: function(response) {
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
    </script>
@endsection
