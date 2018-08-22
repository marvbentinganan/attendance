@extends('layouts.app')
@push('header_scripts')
<script src="{{ asset('plugins/vuejs/vue.js') }}"></script>
@endpush
@section('left')
@include('partials.left-menu')
@endsection

@section('content')
<div class="ui top attached large breadcrumb segment">
    <a href="{{ url('/home') }}" class="section"><i class="home icon"></i>Home</a>
    <div class="divider"><i class="blue ion-chevron-right icon"></i></div>
    <a href="{{ route('students') }}" class="section">Students</a>
    <div class="divider"><i class="blue ion-chevron-right icon"></i></div>
</div>
<div class="ui centered header">List of Students</div>
<div class="ui top attached segment">
    <div class="ui fluid icon input">
        <input type="text" name="keyword" v-model="keyword" id="" placeholder="Search for Student...">
        <i class="inverted circular search icon"></i>
    </div>
</div>
<table class="ui attached compact celled table">
    <thead>
        <th class="center aligned">ID Number</th>
        <th class="center aligned">Name</th>
        <th class="center aligned">Group</th>
    </thead>
    <tbody>
        <tr v-for="student in filteredStudents">
            <td>@{{ student.id_now }}</td>
            <td>@{{ student.firstname }} @{{ student.lastname }}</td>
            <td>@{{ student.group.name }}</td>
        </tr>
    </tbody>
</table>
@endsection

@section('right')
<div class="ui top attached header"><i class="ion-plus-circled icon"></i> Add Student</div>
<div class="ui attached segment">
    <form action="" method="POST" id="student-form" class="ui small form" @submit.prevent="addStudent()">
        @csrf
        <div class="field">
            <div class="ui left icon input">
                <input type="text" name="firstname" id="" v-model="student.firstname" placeholder="Firstname...">
                <i class="ion-pricetag icon"></i>
            </div>
        </div>
        <div class="field">
            <div class="ui left icon input">
                <input type="text" name="lastname" id="" v-model="student.lastname" placeholder="Lastname...">
                <i class="ion-pricetag icon"></i>
            </div>
        </div>
        <div class="field">
            <div class="ui left icon input">
                <input type="text" name="middlename" id="" v-model="student.middlename" placeholder="Middlename...">
                <i class="ion-pricetag icon"></i>
            </div>
        </div>
        <div class="field">
            <div class="ui left icon input">
                <input type="text" name="id_number" id="" v-model="student.id_number" placeholder="ID Number...">
                <i class="ion-pricetag icon"></i>
            </div>
        </div>
        <div class="field">
            <button type="submit" class="ui animated fade fluid primary icon button">
                <div class="visible content">Add Student</div>
                <div class="hidden content"><i class="ion-person-add icon"></i></div>
            </button>
        </div>
    </form>
</div>
<div class="ui section divider"></div>
<div class="ui top attached header"><i class="ion-upload icon"></i> Upload Students</div>
<div class="ui attached segment">
    <form action="{{ route('students.upload') }}" method="POST" class="ui form" id="uploadForm" enctype="multipart/form-data">
        @csrf
        <div class="field">
            <div class="ui input">
                <input type="file" name="doc" id="file" placeholder="Select File...">
            </div>
        </div>
        <div class="field">
            <button type="submit" class="ui animated fade fluid primary icon button">
                <div class="visible content">Upload</div>
                <div class="hidden content"><i class="ion-upload icon"></i></div>
            </button>
        </div>
    </form>
</div>
@endsection
@push('footer_scripts')
<script src="{{ asset('plugins/axios/axios.min.js') }}"></script>
<script>
	new Vue({
		el: '#app',
		data: {
            keyword : undefined,
            students : {},
            student : {
                firstname : '',
                middlename : '',
                lastname : '',
                id_number : '',
                group_id : '',
            },
        },
        computed : {
            filteredStudents(){
                let students = this.students
                if (this.keyword && this.keyword != null) {
                    students = students.filter((student) => {
                        return student.id_now.indexOf(this.keyword) !== -1
                    })
                }
                return students
            }
        },
        methods: {
         init() {
            this.getStudents();
         },

        getStudents(){
            axios.get('{{ route('students.list') }}')
            .then(response => {
                this.students = response.data;
            })
            .catch(error => {
                console.log(error.response.data);
            })
        },

        addStudent(){
            axios.post('{{ route('student.add') }}', this.$data.student)
            .then(response => {
                $('#student-form')[0].reset('form'),
                this.getStudents(),
                toastr.success(response.data);
            })
            .catch(error => {
                console.log(error.response.data);
            });
        },
    },
    created() {
        this.init();
        }
});
    $('.dropdown').dropdown();
</script>
@endpush
