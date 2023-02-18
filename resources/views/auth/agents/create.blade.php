@extends('layouts.app')
<style>
    label {
        font-size: 1৪px;

    }

    input {
        height: 24px;
    }

    input[type=text] {
        border: 1px solid rgba(9, 9, 104, 0.329);

    }

    .form-header {
        width: 100%;
        font-size: 20px;
        background-color: #0f9647;
        color: aliceblue;
        text-align: center;
        padding: 2px;

    }

    .btn {
        background-color: #0f9647;
        color: aliceblue;
    }

    .footer {
        height: 30px;
        background-color: lightgray;
    }
</style>
<style>
    /* Chrome, Safari, Edge, Opera */
    input::-webkit-outer-spin-button,
    input::-webkit-inner-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }

    /* Firefox */
    input[type=number] {
        -moz-appearance: textfield;
    }

    .form-control {
        background: #f5f6f7;
    }

    ::selection {
        background: #FE5757;
        color: #fff;
        text-shadow: none;
    }

    .input-group {
        margin-bottom: 0px;
    }

    /* For Datepicker Toggle */
    .show {
        display: none;
    }

    /* message close */
    .custom-alert {
        position: fixed;
        top: 50px;
        right: 0;
        z-index: 99999;
        width: 300px;
        margin: 0;
        color: #fff;
        border: 0;
    }

    .btn-close {
        background: transparent;
        border: 0;
        float: left;
        font-size: 16px;
        padding: 0;
        color: #fff !important;
    }

    .bg-success {
        background: #52c234;
        background: -webkit-linear-gradient(to left, #061700, #52c234);
        background: linear-gradient(to left, #061700, #52c234);
    }

    .bg-danger {
        background: #DC2424;
        /* fallback for old browsers */
        background: -webkit-linear-gradient(to right, #4A569D, #DC2424);
        /* Chrome 10-25, Safari 5.1-6 */
        background: linear-gradient(to right, #4A569D, #DC2424);
        /* W3C, IE 10+/ Edge, Firefox 16+, Chrome 26+, Opera 12+, Safari 7+ */
    }

    .moveIconstyle {
        font-size: 16px;
        margin: 2px 10px 2px 0;
    }
</style>
@section('content')
<div class="container">
    <!-- @include('admin.inc.messages') -->
    <div class="row justify-content-center">
        <!-- Start login form -->
        <div class="col-lg-3 col-md-4 col-sm-12">
            <!-- <div class="col-lg-12 col-md-8"> -->

            <!-- Start Login form -->
                <div class="card">
                    <div class="card-body p-0">
                        <div class="form-header mb-4">User Login</div>
                        <div class="row mb-3 px-4">
                            <form method="POST" action="{{ route('login') }}">
                                @csrf
                                <div class="col-12 mb-2">
                                    <label for="email" class="form-label">E-Mail Address</label>
                                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                                    @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                                <div class="col-12">
                                    <label for="password" class="form-label">Password</label>
                                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

                                    @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                                <div class="col-12 mt-3">
                                    <button type="submit" class="btn btn-primary">
                                        {{ __('Login') }}
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            <!-- End Login form -->

            <div class="card mt-3">
                <div class="card-body p-0">
                    <div class="form-header mb-4 px-4">Mail Section</div>
                    <div class="row mb-3">

                    </div>
                </div>
            </div>
            <div class="card mt-3">
                <div class="card-body p-0">
                    <div class="form-header mb-4">Notice</div>
                    <div class="row mb-3 px-4">
                        <div class="col-12">
                            <a href="#" target="_blank" class="nav">Ministry of EW&OE</a>
                            <a href="#" target="_blank" class="nav">WEWB</a>
                            <a href="#" target="_blank" class="nav">Probashi Kallyan Bank</a>
                            <a href="#" target="_blank" class="nav">BOESL</a>
                            <a href="#" target="_blank" class="nav">National Web Portal</a>
                            <a href="#" target="_blank" class="nav">BAIRA</a>
                            <a href="#" target="_blank" class="nav">e- Filling System(Nothi)</a>
                            <a href="#" target="_blank" class="nav">Online Passport Application</a>
                            <a href="#" target="_blank" class="nav">RMMRU</a>
                            <a href="#" target="_blank" class="nav">IOM</a>
                            <a href="#" target="_blank" class="nav">UN WOMEN</a>
                            <a href="#" target="_blank" class="nav">DNET</a>
                            <a href="#" target="_blank" class="nav">BRAC</a>
                            <a href="#" target="_blank" class="nav">Bangladesh Bank</a>
                            <a href="#" target="_blank" class="nav">DTTTI</a>
                            <a href="#" target="_blank" class="nav">Labour wings</a>
                            <a href="#" target="_blank" class="nav">Online Complain</a>
                            <a href="#" target="_blank" class="nav">Online Visa Checking</a>
                        </div>

                    </div>
                </div>
            </div>
            <!-- </div> -->
        </div>
        <!-- End login from -->
        <!-- Start General Information -->
        <div class="col-lg-9 col-md-8 col-sm-12">
            <!-- Start Registration Form -->
            <form role="form" action="{{ route('agents.store') }}" method="post" enctype="multipart/form-data" autocomplete="off">
                @csrf
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card mb-3">
                            <div class="card-body p-0">
                                <div class="form-header mb-4">Personal Information</div>
                                <div class="row mb-3 px-4">
                                    <div class="col-md-4 col-sm-12">
                                        <label for="position_desierd" class="form-label">Position Desired</label>
                                        <select name="position_desierd" class="form-control" id="position_desierd" required>
                                            <option value="select">Select</option>

                                            <option value="1">Accountant</option>

                                            <option value="2">Administrative Officer</option>

                                            <option value="3">Agriculture Engineer</option>

                                            <option value="4">Agriculture Labour</option>

                                            <option value="5">Air Conditioning Engineer</option>

                                            <option value="6">Air Conditioning Technician</option>

                                            <option value="7">Air Hostess/Stewards</option>

                                            <option value="8">Aluminium Technician</option>

                                            <option value="9">Anesthesiologist</option>

                                            <option value="10">Architect</option>

                                            <option value="11">Architectural Labour</option>

                                            <option value="12">Artist</option>

                                            <option value="13">Auto Denter</option>

                                            <option value="14">Auto Painter</option>

                                            <option value="15">Autolubricator and Oiler</option>

                                            <option value="16">Automobile Engineer</option>

                                            <option value="17">Automobile Mechanic/Technician</option>

                                            <option value="18">Baby Sitter</option>

                                            <option value="19">Baker</option>

                                            <option value="20">Banker</option>

                                            <option value="21">Barber</option>

                                            <option value="22">Biochemistry Specialist</option>

                                            <option value="23">Biologist</option>

                                            <option value="24">Black Smith</option>

                                            <option value="25">Blood Bank Technician</option>

                                            <option value="26">Business</option>

                                            <option value="27">Butcher</option>

                                            <option value="28">Car Washing and Painting</option>

                                            <option value="29">Cardiologist</option>

                                            <option value="30">Care Taker</option>

                                            <option value="31">Carpenter</option>

                                            <option value="32">Carpet Labour</option>

                                            <option value="33">Cashier</option>

                                            <option value="34">Chartered Accountant</option>

                                            <option value="35">Chemical Engineer</option>

                                            <option value="36">Chemist</option>

                                            <option value="37">Civil Engineer</option>

                                            <option value="38">Cleaner</option>

                                            <option value="39">Clerk</option>

                                            <option value="40">Coffee or Tea Maker</option>

                                            <option value="41">Coiling Machine Operator</option>

                                            <option value="42">Computer Engineer</option>

                                            <option value="43">Computer Operator</option>

                                            <option value="44">Computer Programmer/Software Developer</option>

                                            <option value="45">Computer Technician/Hardware Engineer</option>

                                            <option value="46">Concrete Mixer Man</option>

                                            <option value="47">Construction Worker</option>

                                            <option value="48">Cook/Chef</option>

                                            <option value="49">Data Entry Operator</option>

                                            <option value="50">Database Administrator</option>

                                            <option value="51">Decoration Labour</option>

                                            <option value="52">Dental Technician</option>

                                            <option value="53">Dentist</option>

                                            <option value="54">Dermatologist</option>

                                            <option value="55">Dish Cleaner</option>

                                            <option value="56">Dispensers</option>

                                            <option value="57">Doctor</option>

                                            <option value="58">Door Fixer</option>

                                            <option value="59">Door Maker</option>

                                            <option value="60">Drafts Man</option>

                                            <option value="61">Driver</option>

                                            <option value="62">Electrical Drafts Man</option>

                                            <option value="63">Electrical and Electronic Engineer</option>

                                            <option value="64">Electrician</option>

                                            <option value="65">Electronic Mechanic</option>

                                            <option value="66">Embroidery/Tailor</option>

                                            <option value="67">Factory Worker</option>

                                            <option value="68">Farmer</option>

                                            <option value="69">Fashion Designer</option>

                                            <option value="70">Fireman</option>

                                            <option value="71">Fisherman</option>

                                            <option value="72">Fitter</option>

                                            <option value="73">Flight Attendant</option>

                                            <option value="74">Food Server</option>

                                            <option value="75">Foreman</option>

                                            <option value="77">Fuel Man</option>

                                            <option value="78">Gantry Operator</option>

                                            <option value="79">Gardener</option>

                                            <option value="80">Garments Worker</option>

                                            <option value="81">Gas Pump Attendant</option>

                                            <option value="82">Gas Worker</option>

                                            <option value="83">General Surgery Specialist</option>

                                            <option value="84">General Health Specialist</option>

                                            <option value="85">Gold Smith</option>

                                            <option value="86">Grinder</option>

                                            <option value="87">Grocer</option>

                                            <option value="88">Gynecologist</option>

                                            <option value="89">Hairdresser</option>

                                            <option value="90">Heavy Vehicle Driver</option>

                                            <option value="91">Helper</option>

                                            <option value="92">Horse Rider</option>

                                            <option value="93">Hospital Attendant</option>

                                            <option value="94">Hospital Management</option>

                                            <option value="95">Hotel Boy</option>

                                            <option value="96">House Keeper</option>

                                            <option value="97">House Worker</option>

                                            <option value="98">IT Consultant</option>

                                            <option value="99">IT Professional</option>

                                            <option value="100">Imam/Muazzem</option>

                                            <option value="101">Industrial Engineer</option>

                                            <option value="102">Infectious Disease Specialist</option>

                                            <option value="103">Interior Designer</option>

                                            <option value="104">Iron man</option>

                                            <option value="105">Journalist</option>

                                            <option value="106">Juice Maker</option>

                                            <option value="107">Kitchen Worker</option>

                                            <option value="108">Lab. Technician</option>

                                            <option value="109">Labour</option>

                                            <option value="110">Labour Controller</option>

                                            <option value="111">Laundry Man</option>

                                            <option value="112">Lawyer</option>

                                            <option value="113">Leather Technician</option>

                                            <option value="114">Librarian</option>

                                            <option value="115">Machine Operator</option>

                                            <option value="116">Maintenance Engineer</option>

                                            <option value="117">Maintenance Technician</option>

                                            <option value="118">Maintenance and System Support</option>

                                            <option value="199">Manufacturing</option>

                                            <option value="119">Marine Engineer</option>

                                            <option value="120">Marketing Executive/Marketing Manager</option>

                                            <option value="121">Marketing Specialist</option>

                                            <option value="122">Mason</option>

                                            <option value="123">Mechanical Drafts Man</option>

                                            <option value="124">Mechanical Engineer</option>

                                            <option value="125">Mechanical Technician</option>

                                            <option value="126">Medical Technician</option>

                                            <option value="127">Medicine Specialist</option>

                                            <option value="128">Merchandiser</option>

                                            <option value="129">Metallurgical Engineer</option>

                                            <option value="130">Microbiologist</option>

                                            <option value="131">Naval Architect</option>

                                            <option value="132">Neonatal Specialist</option>

                                            <option value="133">Nerves Surgery Specialist</option>

                                            <option value="134">Network Administrator</option>

                                            <option value="135">Network Engineer</option>

                                            <option value="136">Network Technician</option>

                                            <option value="137">Nurse</option>

                                            <option value="138">Nutrition Specialist</option>

                                            <option value="139">Office Assistant</option>

                                            <option value="140">Oil Changer</option>

                                            <option value="141">Oxygen Welder</option>

                                            <option value="142">Painter</option>

                                            <option value="143">Petro-Chemical Engineer</option>

                                            <option value="144">Pharmacist</option>

                                            <option value="145">Physician</option>

                                            <option value="146">Physiologist</option>

                                            <option value="147">Pipe Worker</option>

                                            <option value="200">Plantation</option>

                                            <option value="148">Plasterer</option>

                                            <option value="149">Plumber</option>

                                            <option value="150">Plumbing Drafts Man</option>

                                            <option value="151">Porter</option>

                                            <option value="152">Private Service</option>

                                            <option value="153">Project Coordinator</option>

                                            <option value="154">Project Engineer</option>

                                            <option value="155">Project Manager</option>

                                            <option value="156">Receptionist</option>

                                            <option value="157">Recreation Attendant</option>

                                            <option value="158">Rod Binder</option>

                                            <option value="159">Sales Manager</option>

                                            <option value="160">Sales Representative</option>

                                            <option value="161">Salesman</option>

                                            <option value="162">Sandwich Maker</option>

                                            <option value="163">Screen Fitter</option>

                                            <option value="164">Screen Maker</option>

                                            <option value="165">Seaman</option>

                                            <option value="166">Seat Maker</option>

                                            <option value="167">Security Guard</option>

                                            <option value="168">Shepherd</option>

                                            <option value="169">Shoe Maker</option>

                                            <option value="170">Sign Writer</option>

                                            <option value="171">Sofa Maker</option>

                                            <option value="172">Specialist Doctor</option>

                                            <option value="173">Steel Worker</option>

                                            <option value="174">Store Keeper</option>

                                            <option value="175">Student</option>

                                            <option value="176">Surgeon</option>

                                            <option value="177">System Administrator</option>

                                            <option value="178">System Analyst</option>

                                            <option value="179">System Designer</option>

                                            <option value="180">Teacher</option>

                                            <option value="181">Telecommunication Engineer</option>

                                            <option value="182">Telephone Mechanic</option>

                                            <option value="183">Telephone Operator</option>

                                            <option value="184">Television Photographer</option>

                                            <option value="185">Textile Engineer</option>

                                            <option value="186">Thermal Engineer</option>

                                            <option value="187">Tiles Worker</option>

                                            <option value="188">Tourist Guide</option>

                                            <option value="189">Tower Crane Operator</option>

                                            <option value="190">Trainer</option>

                                            <option value="191">Translator</option>

                                            <option value="192">Tug Master</option>

                                            <option value="193">Typist</option>

                                            <option value="194">Vulcanizer</option>

                                            <option value="195">Waiter</option>

                                            <option value="196">Web Designer/Developer</option>

                                            <option value="197">Welder/Fabricator</option>

                                            <option value="198">Wood Worker</option>

                                            <option value="76">Workshop Worker</option>

                                        </select>
                                    </div>

                                    <div class="col-md-4 col-sm-12">
                                        <label for="agent_name" class="form-label">Name</label>
                                        <input type="text" class="form-control" name="agent_name" id="agent_name" placeholder="আবেদনকারীর পুরো নাম লিখুন" required>
                                    </div>


                                    <div class="col-md-4 col-sm-12">
                                        <div class="form-group">
                                            <br>
                                            <label><input type="radio" name="gender" class="minimal" value="Male"> Male </label>
                                            <label><input type="radio" name="gender" class="minimal" value="Female"> Female </label>
                                        </div>
                                    </div>


                                    <div class="col-md-4 col-sm-12">
                                        <label for="city_address" class="form-label">City Address</label>
                                        <textarea name="city_address" id="city_address" class="form-control"></textarea>
                                    </div>

                                    <div class="col-md-4 col-sm-12">
                                        <label for="provisional_address" class="form-label">Provisional Address</label>
                                        <textarea name="provisional_address" id="provisional_address" class="form-control"></textarea>
                                    </div>

                                    <div class="col-md-4 col-sm-12">
                                        <label for="telephone" class="form-label">Telephone</label>
                                        <input type="text" class="form-control" name="telephone" id="telephone" placeholder="Enter Telephone Number">
                                    </div>

                                    <div class="col-md-4 col-sm-12">
                                        <label for="phone" class="form-label">Cell Phone</label>
                                        <input type="text" class="form-control" name="phone" id="phone" placeholder="Enter Phone Number">
                                    </div>
                                    <div class="col-md-4 col-sm-12">
                                        <label for="email" class="form-label">Email Address</label>
                                        <input type="email" class="form-control" name="email" id="email" placeholder="Email Address">
                                    </div>
                                    <div class="col-md-4 col-sm-12">
                                        <label for="password" class="form-label">Password</label>
                                        <input type="password" name="password" class="form-control" id="password" placeholder="Password">
                                        @if ($errors->has('password'))
                                        <p class="text-danger">
                                            <small>{{ $errors->first('password') }}</small>
                                        </p>
                                        @endif
                                    </div>
                                    <div class="col-md-4 col-sm-12">
                                        <label for="password_confirmation">Confirm Password</label>
                                        <input type="password" name="password_confirmation" class="form-control" id="password_confirmation" placeholder="Confirm Password">
                                        @if ($errors->has('password_confirmation'))
                                        <p class="text-danger">
                                            <small>{{ $errors->first('password_confirmation') }}</small>
                                        </p>
                                        @endif
                                    </div>
                                    <div class="col-md-4 col-sm-12">
                                        <label for="dob" class="form-label">Date of Birth</label>
                                        <input type="date" class="form-control" name="dob" id="dob" placeholder="Spouse's Name">
                                    </div>
                                    <div class="col-md-4 col-sm-12">
                                        <label for="dob_place" class="form-label">Date of Birth Place</label>
                                        <input type="text" class="form-control" name="dob_place" id="dob_place" placeholder="Spouse's Name">
                                    </div>
                                    <div class="col-md-4 col-sm-12">
                                        <label for="civil_status" class="form-label">Civil Status</label>
                                        <input type="text" class="form-control" name="civil_status" id="civil_status" placeholder="Civil Status">
                                    </div>
                                    <div class="col-md-4 col-sm-12">
                                        <label for="citizenship" class="form-label">Citizenship</label>
                                        <input type="text" class="form-control" name="citizenship" id="citizenship" placeholder="Spouse's Name">
                                    </div>
                                    <div class="col-md-4 col-sm-12">
                                        <label for="height" class="form-label">Height</label>
                                        <input type="text" class="form-control" name="height" id="height" placeholder="Ex. 5.6 inch">
                                    </div>
                                    <div class="col-md-4 col-sm-12">
                                        <label for="weight" class="form-label">Weight</label>
                                        <input type="text" class="form-control" name="weight" id="weight" placeholder="Ex. 60kg">
                                    </div>
                                    <div class="col-md-4 col-sm-12">
                                        <label for="religion" class="form-label">Religion</label>
                                        <select name="religion" class="form-control" id="religion" required>
                                            <option value="Islam" selected="selected">Islam</option>
                                            <option value="Hinduism">Hinduism</option>
                                            <option value="Christianity">Christianity</option>
                                            <option value="Buddhism">Buddhism</option>
                                            <option value="Other">Other</option>
                                        </select>
                                    </div>
                                    <div class="col-md-4 col-sm-12">
                                        <label for="spouse_name" class="form-label">Spouse Name</label>
                                        <input type="text" class="form-control" name="spouse_name" id="spouse_name" placeholder="Spouse's Name">
                                    </div>
                                    <div class="col-md-4 col-sm-12">
                                        <label for="spouse_occupation" class="form-label">Spouse Occupation</label>
                                        <input type="text" class="form-control" name="spouse_occupation" id="spouse_occupation" placeholder="NID Number 124566789" required>
                                    </div>
                                    <div class="col-md-4 col-sm-12">
                                        <label for="children_name" class="form-label">Name of Children</label>
                                        <input type="text" name="children_name" id="children_name" class="form-control" placeholder="Name of Children">
                                    </div>
                                    <div class="col-md-4 col-sm-12">
                                        <label for="children_date_of_birth" class="form-label">Children Date of Birth</label>
                                        <input type="date" class="form-control" name="children_date_of_birth" id="children_date_of_birth" placeholder="children_date_of_birth">
                                    </div>
                                    <div class="col-md-4 col-sm-12">
                                        <label for="fathers_name" class="form-label">Father's Name</label>
                                        <input type="text" class="form-control" name="fathers_name" id="fathers_name" placeholder="Father's Name" required>
                                    </div>
                                    <div class="col-md-4 col-sm-12">
                                        <label for="father_occupation" class="form-label">Father Occupation</label>
                                        <input type="text" class="form-control" name="father_occupation" id="father_occupation" placeholder="Father Occupation" required>
                                    </div>
                                    <div class="col-md-4 col-sm-12">
                                        <label for="mothers_name" class="form-label">Mother's Name</label>
                                        <input type="text" class="form-control" name="mothers_name" id="mothers_name" placeholder="Mother's Name" required>
                                    </div>
                                    <div class="col-md-4 col-sm-12">
                                        <label for="mother_occupation" class="form-label">Mother's Occupation</label>
                                        <input type="text" class="form-control" name="mother_occupation" id="mother_occupation" placeholder="Mother Occupation" required>
                                    </div>
                                    <div class="col-md-4 col-sm-12">
                                        <label for="image" class="">Upload Photo</label>
                                        <input type="file" class="form-control" name="image" id="image" required>
                                    </div>
                                    <div class="col-md-4 col-sm-12">
                                        <label for="language" class="form-label">Language/Dialect Spoken and Written</label>
                                        <select name="language" id="language" class="form-control" required>
                                            <option value="select">Select</option>
                                            <option value="Abenaki">Abenaki</option>
                                            <option value="Arabic">Arabic</option>
                                            <option value="Aramaic">Aramaic</option>
                                            <option value="Ayapathu">Ayapathu</option>
                                            <option value="Balinese">Balinese</option>
                                            <option value="Bangla">Bangla</option>
                                            <option value="Bobangi">Bobangi</option>
                                            <option value="Bulgarian">Bulgarian</option>
                                            <option value="Burmese">Burmese</option>
                                            <option value="Catalan">Catalan</option>
                                            <option value="Chinese">Chinese</option>
                                            <option value="Chinook">Chinook</option>
                                            <option value="Cree">Cree</option>
                                            <option value="Creole">Creole</option>
                                            <option value="Czech">Czech</option>
                                            <option value="Danish">Danish</option>
                                            <option value="Dutch">Dutch</option>
                                            <option value="Eggon">Eggon</option>
                                            <option value="English">English</option>
                                            <option value="Farsi">Farsi</option>
                                            <option value="French">French</option>
                                            <option value="Gaelic">Gaelic</option>
                                            <option value="German">German</option>
                                            <option value="Gothic">Gothic</option>
                                            <option value="Greek">Greek</option>
                                            <option value="Haida">Haida</option>
                                            <option value="Hindi">Hindi</option>
                                            <option value="Hungarian">Hungarian</option>
                                            <option value="Indonesian">Indonesian</option>
                                            <option value="Italian">Italian</option>
                                            <option value="Jangshung">Jangshung</option>
                                            <option value="Japanese">Japanese</option>
                                            <option value="Konkani">Konkani</option>
                                            <option value="Korean">Korean</option>
                                            <option value="Koyo">Koyo</option>
                                            <option value="Latin">Latin</option>
                                            <option value="Malagasy">Malagasy</option>
                                            <option value="Malay">Malay</option>
                                            <option value="Malayalam">Malayalam</option>
                                            <option value="Mayan">Mayan</option>
                                            <option value="Nahuatl">Nahuatl</option>
                                            <option value="Nande">Nande</option>
                                            <option value="Pidgin">Pidgin</option>
                                            <option value="Pirah">Pirah</option>
                                            <option value="Polish">Polish</option>
                                            <option value="Prussian">Prussian</option>
                                            <option value="Quechua">Quechua</option>
                                            <option value="Romanian">Romanian</option>
                                            <option value="Russian">Russian</option>
                                            <option value="Saanich">Saanich</option>
                                            <option value="Sign">Sign</option>
                                            <option value="Spanish">Spanish</option>
                                            <option value="Swedish">Swedish</option>
                                            <option value="Tagalog">Tagalog</option>
                                            <option value="Tamil">Tamil</option>
                                            <option value="Thai">Thai</option>
                                            <option value="Urdu">Urdu</option>
                                            <option value="Venda">Venda</option>
                                            <option value="Vietnamese">Vietnamese</option>
                                        </select>
                                    </div>

                                    <div class="col-md-4 col-sm-12">
                                        <label for="emergency_contact_person" class="form-label">Persons to be contacted in case of emergency</label>
                                        <input type="text" class="form-control" name="emergency_contact_person" id="emergency_contact_person" placeholder="Emergency Contact Person Name">
                                    </div>
                                    <div class="col-md-4 col-sm-12">
                                        <label for="emergency_person_address_tel" class="form-label">His/Her Address and Tel</label>
                                        <textarea name="emergency_person_address_tel" id="emergency_person_address_tel" class="form-control"></textarea>
                                    </div>


                                </div>

                            </div>
                        </div>
                    </div>



                    <!-- Start Educaiton section -->
                    <div class="col-lg-12">
                        <div class="card mb-3">
                            <div class="card-body p-0">
                                <div class="form-header mb-4">Educational Attainment</div>
                                <div class="row mb-3 px-4">
                                    <div class="col-md-6 col-sm-12">
                                        <label for="elementary" class="form-label">Elementary</label>
                                        <input type="text" class="form-control" name="elementary" id="elementary" placeholder="Group/Subject" required>
                                    </div>
                                    <div class="col-md-6 col-sm-12">
                                        <label for="elementary_passing_year" class="form-label">Year Graduated</label>
                                        <select name="elementary_passing_year" class="form-control" id="elementary_passing_year" required>
                                            <option value="select">Select</option>
                                            <option value="1950">1950</option>
                                            <option value="1951">1951</option>
                                            <option value="1952">1952</option>
                                            <option value="1953">1953</option>
                                            <option value="1954">1954</option>
                                            <option value="1955">1955</option>
                                            <option value="1956">1956</option>
                                            <option value="1957">1957</option>
                                            <option value="1958">1958</option>
                                            <option value="1959">1959</option>
                                            <option value="1960">1960</option>
                                            <option value="1961">1961</option>
                                            <option value="1962">1962</option>
                                            <option value="1963">1963</option>
                                            <option value="1964">1964</option>
                                            <option value="1965">1965</option>
                                            <option value="1966">1966</option>
                                            <option value="1967">1967</option>
                                            <option value="1968">1968</option>
                                            <option value="1969">1969</option>
                                            <option value="1970">1970</option>
                                            <option value="1971">1971</option>
                                            <option value="1972">1972</option>
                                            <option value="1973">1973</option>
                                            <option value="1974">1974</option>
                                            <option value="1975">1975</option>
                                            <option value="1976">1976</option>
                                            <option value="1977">1977</option>
                                            <option value="1978">1978</option>
                                            <option value="1979">1979</option>
                                            <option value="1980">1980</option>
                                            <option value="1981">1981</option>
                                            <option value="1982">1982</option>
                                            <option value="1983">1983</option>
                                            <option value="1984">1984</option>
                                            <option value="1985">1985</option>
                                            <option value="1986">1986</option>
                                            <option value="1987">1987</option>
                                            <option value="1988">1988</option>
                                            <option value="1989">1989</option>
                                            <option value="1990">1990</option>
                                            <option value="1991">1991</option>
                                            <option value="1992">1992</option>
                                            <option value="1993">1993</option>
                                            <option value="1994">1994</option>
                                            <option value="1995">1995</option>
                                            <option value="1996">1996</option>
                                            <option value="1997">1997</option>
                                            <option value="1998">1998</option>
                                            <option value="1999">1999</option>
                                            <option value="2000">2000</option>
                                            <option value="2001">2001</option>
                                            <option value="2002">2002</option>
                                            <option value="2003">2003</option>
                                            <option value="2004">2004</option>
                                            <option value="2005">2005</option>
                                            <option value="2006">2006</option>
                                            <option value="2007">2007</option>
                                            <option value="2008">2008</option>
                                            <option value="2009">2009</option>
                                            <option value="2010">2010</option>
                                            <option value="2011">2011</option>
                                            <option value="2012">2012</option>
                                            <option value="2013">2013</option>
                                            <option value="2014">2014</option>
                                            <option value="2015">2015</option>
                                            <option value="2016">2016</option>
                                            <option value="2017">2017</option>
                                            <option value="2017">2018</option>
                                            <option value="2017">2019</option>
                                            <option value="2017">2020</option>
                                            <option value="2017">2021</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6 col-sm-12">
                                        <label for="high_school" class="form-label">High School</label>
                                        <input type="text" class="form-control" name="high_school" id="high_school" placeholder="High School" required>
                                    </div>
                                    <div class="col-md-6 col-sm-12">
                                        <label for="high_school_passing_year" class="form-label">Year Graduated</label>
                                        <select name="high_school_passing_year" class="form-control" id="high_school_passing_year" required>
                                            <option value="select">Select</option>
                                            <option value="1950">1950</option>
                                            <option value="1951">1951</option>
                                            <option value="1952">1952</option>
                                            <option value="1953">1953</option>
                                            <option value="1954">1954</option>
                                            <option value="1955">1955</option>
                                            <option value="1956">1956</option>
                                            <option value="1957">1957</option>
                                            <option value="1958">1958</option>
                                            <option value="1959">1959</option>
                                            <option value="1960">1960</option>
                                            <option value="1961">1961</option>
                                            <option value="1962">1962</option>
                                            <option value="1963">1963</option>
                                            <option value="1964">1964</option>
                                            <option value="1965">1965</option>
                                            <option value="1966">1966</option>
                                            <option value="1967">1967</option>
                                            <option value="1968">1968</option>
                                            <option value="1969">1969</option>
                                            <option value="1970">1970</option>
                                            <option value="1971">1971</option>
                                            <option value="1972">1972</option>
                                            <option value="1973">1973</option>
                                            <option value="1974">1974</option>
                                            <option value="1975">1975</option>
                                            <option value="1976">1976</option>
                                            <option value="1977">1977</option>
                                            <option value="1978">1978</option>
                                            <option value="1979">1979</option>
                                            <option value="1980">1980</option>
                                            <option value="1981">1981</option>
                                            <option value="1982">1982</option>
                                            <option value="1983">1983</option>
                                            <option value="1984">1984</option>
                                            <option value="1985">1985</option>
                                            <option value="1986">1986</option>
                                            <option value="1987">1987</option>
                                            <option value="1988">1988</option>
                                            <option value="1989">1989</option>
                                            <option value="1990">1990</option>
                                            <option value="1991">1991</option>
                                            <option value="1992">1992</option>
                                            <option value="1993">1993</option>
                                            <option value="1994">1994</option>
                                            <option value="1995">1995</option>
                                            <option value="1996">1996</option>
                                            <option value="1997">1997</option>
                                            <option value="1998">1998</option>
                                            <option value="1999">1999</option>
                                            <option value="2000">2000</option>
                                            <option value="2001">2001</option>
                                            <option value="2002">2002</option>
                                            <option value="2003">2003</option>
                                            <option value="2004">2004</option>
                                            <option value="2005">2005</option>
                                            <option value="2006">2006</option>
                                            <option value="2007">2007</option>
                                            <option value="2008">2008</option>
                                            <option value="2009">2009</option>
                                            <option value="2010">2010</option>
                                            <option value="2011">2011</option>
                                            <option value="2012">2012</option>
                                            <option value="2013">2013</option>
                                            <option value="2014">2014</option>
                                            <option value="2015">2015</option>
                                            <option value="2016">2016</option>
                                            <option value="2017">2017</option>
                                            <option value="2017">2018</option>
                                            <option value="2017">2019</option>
                                            <option value="2017">2020</option>
                                            <option value="2017">2021</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6 col-sm-12">
                                        <label for="college" class="form-label">College</label>
                                        <input type="text" class="form-control" name="college" id="college" placeholder="College" required>
                                    </div>
                                    <div class="col-md-6 col-sm-12">
                                        <label for="college_passing_year" class="form-label">Year Graduated</label>
                                        <select name="college_passing_year" class="form-control" id="college_passing_year" required>
                                            <option value="select">Select</option>
                                            <option value="1950">1950</option>
                                            <option value="1951">1951</option>
                                            <option value="1952">1952</option>
                                            <option value="1953">1953</option>
                                            <option value="1954">1954</option>
                                            <option value="1955">1955</option>
                                            <option value="1956">1956</option>
                                            <option value="1957">1957</option>
                                            <option value="1958">1958</option>
                                            <option value="1959">1959</option>
                                            <option value="1960">1960</option>
                                            <option value="1961">1961</option>
                                            <option value="1962">1962</option>
                                            <option value="1963">1963</option>
                                            <option value="1964">1964</option>
                                            <option value="1965">1965</option>
                                            <option value="1966">1966</option>
                                            <option value="1967">1967</option>
                                            <option value="1968">1968</option>
                                            <option value="1969">1969</option>
                                            <option value="1970">1970</option>
                                            <option value="1971">1971</option>
                                            <option value="1972">1972</option>
                                            <option value="1973">1973</option>
                                            <option value="1974">1974</option>
                                            <option value="1975">1975</option>
                                            <option value="1976">1976</option>
                                            <option value="1977">1977</option>
                                            <option value="1978">1978</option>
                                            <option value="1979">1979</option>
                                            <option value="1980">1980</option>
                                            <option value="1981">1981</option>
                                            <option value="1982">1982</option>
                                            <option value="1983">1983</option>
                                            <option value="1984">1984</option>
                                            <option value="1985">1985</option>
                                            <option value="1986">1986</option>
                                            <option value="1987">1987</option>
                                            <option value="1988">1988</option>
                                            <option value="1989">1989</option>
                                            <option value="1990">1990</option>
                                            <option value="1991">1991</option>
                                            <option value="1992">1992</option>
                                            <option value="1993">1993</option>
                                            <option value="1994">1994</option>
                                            <option value="1995">1995</option>
                                            <option value="1996">1996</option>
                                            <option value="1997">1997</option>
                                            <option value="1998">1998</option>
                                            <option value="1999">1999</option>
                                            <option value="2000">2000</option>
                                            <option value="2001">2001</option>
                                            <option value="2002">2002</option>
                                            <option value="2003">2003</option>
                                            <option value="2004">2004</option>
                                            <option value="2005">2005</option>
                                            <option value="2006">2006</option>
                                            <option value="2007">2007</option>
                                            <option value="2008">2008</option>
                                            <option value="2009">2009</option>
                                            <option value="2010">2010</option>
                                            <option value="2011">2011</option>
                                            <option value="2012">2012</option>
                                            <option value="2013">2013</option>
                                            <option value="2014">2014</option>
                                            <option value="2015">2015</option>
                                            <option value="2016">2016</option>
                                            <option value="2017">2017</option>
                                            <option value="2017">2018</option>
                                            <option value="2017">2019</option>
                                            <option value="2017">2020</option>
                                            <option value="2017">2021</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6 col-sm-12">
                                        <label for="degree_name" class="form-label">Degree Received</label>
                                        <input type="text" class="form-control" name="degree_name" id="degree_name" placeholder="Degree Name" required>
                                    </div>
                                    <div class="col-md-6 col-sm-12">
                                        <label for="special_skills" class="form-label">Special Skills</label>
                                        <input type="text" class="form-control" name="special_skills" id="special_skills" placeholder="Degree Name" required>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> <!-- col -->



                    <!-- Start Experience section -->
                    <div class="col-lg-12">
                        <div class="card mb-3">
                            <div class="card-body p-0">
                                <div class="form-header mb-4">Employment Records:</div>
                                <div class="bg-light text-justify p-1 mb-2 px-4">
                                    <h6>Work Experience</h6>
                                </div>
                                <div class="row mb-3 px-4">

                                    <div class="col-md-12 col-sm-12">
                                        <label for="company_name_1" class="form-label">1. Company Name</label>
                                        <input type="text" class="form-control" name="company_name_1" id="company_name_1" placeholder="Enter Company name" required>

                                    </div>
                                    <div class="col-md-4 col-sm-12">
                                        <label for="position_1" class="form-label">Position</label>
                                        <input type="text" class="form-control" name="position_1" id="position_1" placeholder="Job Position" required>

                                    </div>
                                    <div class="col-md-4 col-sm-12">
                                        <label for="from_1" class="form-label">Serve From</label>
                                        <input type="date" class="form-control" name="from_1" id="from_1" required>
                                    </div>
                                    <div class="col-md-4 col-sm-12">
                                        <label for="to_1" class="form-label">Serve To</label>
                                        <input type="date" class="form-control" name="to_1" id="to_1" required>
                                    </div>

                                    <div class="col-md-12 col-sm-12">
                                        <label for="company_name_2" class="form-label">2. Company Name</label>
                                        <input type="text" class="form-control" name="company_name_2" id="company_name_2" placeholder="Enter Company name" required>

                                    </div>
                                    <div class="col-md-4 col-sm-12">
                                        <label for="position_2" class="form-label">Position</label>
                                        <input type="text" class="form-control" name="position_2" id="position_2" placeholder="Job Position" required>

                                    </div>
                                    <div class="col-md-4 col-sm-12">
                                        <label for="from_2" class="form-label">Serve From</label>
                                        <input type="date" class="form-control" name="from_2" id="from_2" required>
                                    </div>
                                    <div class="col-md-4 col-sm-12">
                                        <label for="to_2" class="form-label">Serve To</label>
                                        <input type="date" class="form-control" name="to_2" id="to_2" required>
                                    </div>




                                </div>

                            </div>
                        </div>
                    </div> <!-- col -->

                    <!-- Start Traninng information section -->
                    <div class="col-12">
                        <div class="card mb-3">
                            <div class="card-body p-0">
                                <div class="form-header mb-4">Character Reference</div>

                                <div class="row mb-3 px-4">
                                    <div class="col-md-6 col-sm-12">
                                        <label for="character_refer_name_1" class="form-label">1. Name</label>
                                        <input type="text" class="form-control" name="character_refer_name_1" id="character_refer_name_1" placeholder="Enter Name" required>
                                    </div>
                                    <div class="col-md-6 col-sm-12">
                                        <label for="character_refer_company_name_1" class="form-label">Company name</label>
                                        <input type="text" class="form-control" name="character_refer_company_name_1" id="character_refer_company_name_1" placeholder="Enter Company Name" required>
                                    </div>
                                    <div class="col-md-6 col-sm-12">
                                        <label for="character_refer_position_1" class="form-label">Position</label>
                                        <input type="text" class="form-control" name="character_refer_position_1" id="character_refer_position_1" placeholder="Enter Company Name" required>
                                    </div>
                                    <div class="col-md-6 col-sm-12">
                                        <label for="character_refer_phone_1" class="form-label">Contact No:</label>
                                        <input type="text" class="form-control" name="character_refer_phone_1" id="character_refer_phone_1" placeholder="Enter Company Name" required>
                                    </div>
                                </div>
                                <!-- End row -->
                                <div class="row mb-3 px-4">
                                    <div class="col-md-6 col-sm-12">
                                        <label for="character_refer_name_2" class="form-label">2. Name</label>
                                        <input type="text" class="form-control" name="character_refer_name_2" id="character_refer_name_2" placeholder="Enter Name" required>
                                    </div>
                                    <div class="col-md-6 col-sm-12">
                                        <label for="character_refer_company_name_2" class="form-label">Company name</label>
                                        <input type="text" class="form-control" name="character_refer_company_name_2" id="character_refer_company_name_2" placeholder="Enter Company Name" required>
                                    </div>
                                    <div class="col-md-6 col-sm-12">
                                        <label for="character_refer_position_2" class="form-label">Position</label>
                                        <input type="text" class="form-control" name="character_refer_position_2" id="character_refer_position_2" placeholder="Enter Company Name" required>
                                    </div>
                                    <div class="col-md-6 col-sm-12">
                                        <label for="character_refer_phone_2" class="form-label">Contact No:</label>
                                        <input type="text" class="form-control" name="character_refer_phone_2" id="character_refer_phone_2" placeholder="Enter Company Name" required>
                                    </div>
                                </div>
                                <div class="bg-light text-justify p-1 mb-2 px-4">
                                    <h6>Permanent Address:</h6>
                                </div>
                                <div class="row mb-3 px-4">
                                    <div class="col-md-6 col-sm-12">
                                        <label for="village_permanent" class="form-label">Village:</label>
                                        <input type="text" class="form-control" name="village_permanent" id="village_permanent" placeholder="Enter Institute Name" required>
                                    </div>
                                    <div class="col-md-6 col-sm-12">
                                        <label for="post_office_permanent" class="form-label">Post Office:</label>
                                        <input type="text" class="form-control" name="post_office_permanent" id="post_office_permanent" placeholder="Enter Institute Name" required>
                                    </div>
                                    <div class="col-md-6 col-sm-12">
                                        <label for="district_permanent" class="form-label">District:</label>
                                        <select name="district_permanent" class="form-control" id="district_permanent" required>
                                         @foreach($districts as $district)
                                         <option value="$district->id">{{$district->name}}</option>\
                                         @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-6 col-sm-12">
                                        <label for="police_station_permanent" class="form-label">Police Station:</label>
                                        <select name="police_station_permanent" class="form-control" id="police_station_permanent" required>
                                        @foreach($thanas as $thana)
                                         <option value="$thana->id">{{$thana->name}}</option>\
                                         @endforeach
                                        </select>
                                    </div>
                                </div>
                                <!-- End row -->
                                <div class="bg-light text-justify p-1 mb-2 px-4">
                                    <h6>Present Address:</h6>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value="" id="Chkbox">
                                        <label class="form-check-label" for="Chkbox">
                                            Same as Permanent Address
                                        </label>
                                    </div>
                                </div>
                                <div class="row mb-3 px-4">
                                    <div class="col-md-6 col-sm-12">
                                        <label for="village_present" class="form-label">Village:</label>
                                        <input type="text" class="form-control" name="village_present" id="village_present" placeholder="Enter Institute Name" required>
                                    </div>
                                    <div class="col-md-6 col-sm-12">
                                        <label for="post_office_present" class="form-label">Post Office:</label>
                                        <input type="text" class="form-control" name="post_office_present" id="post_office_present" placeholder="Enter Institute Name" required>
                                    </div>
                                    <div class="col-md-6 col-sm-12">
                                        <label for="district_permanent" class="form-label">District:</label>
                                        <select name="district_permanent" class="form-control" id="district_permanent" required>
                                         @foreach($districts as $district)
                                         <option value="$district->id">{{$district->name}}</option>\
                                         @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-6 col-sm-12">
                                        <label for="police_station_permanent" class="form-label">Police Station:</label>
                                        <select name="police_station_permanent" class="form-control" id="police_station_permanent" required>
                                        @foreach($thanas as $thana)
                                         <option value="$thana->id">{{$thana->name}}</option>\
                                         @endforeach
                                        </select>
                                    </div>
                                </div>
                                <!-- End row -->
                                <div class="row mb-3 px-4">
                                    <div class="col-md-12 col-sm-12">
                                        <label for="dhaka_address" class="form-label">Dhaka Address (If any):</label>
                                        <input type="text" class="form-control" name="dhaka_address" id="dhaka_address" placeholder="Enter Institute Name" required>
                                    </div>
                                </div>
                                <!-- End row -->
                                <div class="bg-light text-justify p-1 mb-2 px-4">
                                    <h6>Passport No:</h6>
                                </div>
                                <div class="row mb-3 px-4">
                                    <div class="col-md-6 col-sm-12">
                                        <label for="passport_no" class="form-label">No:</label>
                                        <input type="text" class="form-control" name="passport_no" id="passport_no" placeholder="Enter Institute Name" required>
                                    </div>
                                    <div class="col-md-6 col-sm-12">
                                        <label for="passport_issue_date" class="form-label">Issue Date:</label>
                                        <input type="date" class="form-control" name="passport_issue_date" id="passport_issue_date" placeholder="Enter Institute Name" required>
                                    </div>
                                    <div class="col-md-6 col-sm-12">
                                        <label for="passport_expiry_date" class="form-label">Expiry Date:</label>
                                        <input type="date" class="form-control" name="passport_expiry_date" id="passport_expiry_date" placeholder="Enter Institute Name" required>
                                    </div>
                                    <div class="col-md-6 col-sm-12">
                                        <label for="nid_no" class="form-label">NID No:</label>
                                        <input type="text" class="form-control" name="nid_no" id="nid_no" placeholder="Enter NID No" required>
                                    </div>
                                </div>
                                <!-- End row -->
                                <div class="row mb-3 px-4">
                                    <div class="col-md-12 col-sm-12">
                                        <label for="experience" class="form-label">Experience (Worked with any Recruiting Agency):</label>
                                        <input type="text" class="form-control" name="experience" id="experience" placeholder="Enter Experience" required>
                                    </div>
                                    <div class="col-md-12 col-sm-12">
                                        <label for="present_appointment" class="form-label">Present Appointment:</label>
                                        <input type="text" class="form-control" name="present_appointment" id="present_appointment" placeholder="Enter Institute Name" required>
                                    </div>
                                    <div class="col-md-12 col-sm-12">
                                        <label for="case_civil_court" class="form-label">GD/Complain/Civil Case at any PS/Civil Court:</label>
                                        <input type="text" class="form-control" name="case_civil_court" id="case_civil_court" placeholder="Enter Institute Name" required>
                                    </div>
                                </div>
                                <!-- End row -->
                                <div class="bg-light text-justify p-1 mb-2 px-4">
                                    <h6>Technical Qualification Name of Institute:</h6>
                                </div>
                                <div class="row mb-3 px-4">
                                    <div class="col-md-6 col-sm-12">
                                        <label for="technical_qualification_institute_name" class="form-label">Technical:</label>
                                        <input type="text" class="form-control" name="technical_qualification_institute_name" id="technical_qualification_institute_name" placeholder="Enter Institute Name" required>
                                    </div>
                                    <div class="col-md-6 col-sm-12">
                                        <label for="other_qualification_institute_name" class="form-label">Other's:</label>
                                        <input type="text" class="form-control" name="other_qualification_institute_name" id="other_qualification_institute_name" placeholder="Enter Institute Name" required>
                                    </div>
                                </div>
                                <!-- End row -->

                                <div class="row mb-3 px-4">
                                    <div class="col-md-6 col-sm-12">
                                        <label for="job_preference_country" class="form-label">Job Preference (If any):</label>
                                        <select name="job_preference_country" id="job_preference_country" class="form-control">
                                            <option value="won_country">Won Country</option>
                                            <option value="foreign_country">Foreign Country</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6 col-sm-12">
                                        <label for="medical_fitness" class="form-label">Medical Fitness:</label>
                                        <select name="medical_fitness" id="medical_fitness" class="form-control">
                                            <option value="fit">Fit</option>
                                            <option value="unfit">Unfit</option>
                                        </select>
                                    </div>
                                </div>
                                <!-- End row -->

                                <div class="row mb-3 px-4">
                                    <div class="col-md-6 col-sm-12">
                                        <button type="submit" class="btn btn-primary mt-3">Send & Preview</button>
                                    </div>
                                </div>
                                <!-- End row -->


                            </div>
                        </div>
                    </div>
                </div>
            </form>
            <!-- End Registration Form -->
        </div>


    </div>











</div>
@endsection