@extends('pcmn::_layouts.default')

@section('content')

    <nav aria-label="breadcrumb" role="navigation">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item"><a href="#">Library</a></li>
            <li class="breadcrumb-item active" aria-current="page">Data</li>
        </ol>
    </nav>

    <h1>
        foobar
        <small class="text-muted">With faded secondary text</small>
    </h1>

    <hr>

    <p class="lead">
        Vivamus sagittis lacus vel augue laoreet rutrum faucibus dolor auctor. Duis mollis, est non commodo luctus.
    </p>

    <hr>

    <form>
        <div class="form-group row">
            <label for="inputEmail3" class="col-sm-2 col-form-label">Email</label>
            <div class="col-sm-10">
                <input type="email" class="form-control" id="inputEmail3" placeholder="Email">
            </div>
        </div>
        <div class="form-group row">
            <label for="inputPassword3" class="col-sm-2 col-form-label">Password</label>
            <div class="col-sm-10">
                <input type="password" class="form-control" id="inputPassword3" placeholder="Password">
            </div>
        </div>
        <fieldset class="form-group">
            <div class="row">
                <legend class="col-form-legend col-sm-2">Radios</legend>
                <div class="col-sm-10">
                    <div class="form-check">
                        <label class="form-check-label">
                            <input class="form-check-input" type="radio" name="gridRadios" id="gridRadios1" value="option1" checked>
                            Option one is this and that&mdash;be sure to include why it's great
                        </label>
                    </div>
                    <div class="form-check">
                        <label class="form-check-label">
                            <input class="form-check-input" type="radio" name="gridRadios" id="gridRadios2" value="option2">
                            Option two can be something else and selecting it will deselect option one
                        </label>
                    </div>
                    <div class="form-check disabled">
                        <label class="form-check-label">
                            <input class="form-check-input" type="radio" name="gridRadios" id="gridRadios3" value="option3" disabled>
                            Option three is disabled
                        </label>
                    </div>
                </div>
            </div>
        </fieldset>
        <div class="form-group row">
            <div class="col-sm-2">Checkbox</div>
            <div class="col-sm-10">
                <div class="form-check">
                    <label class="form-check-label">
                        <input class="form-check-input" type="checkbox"> Check me out
                    </label>
                </div>
            </div>
        </div>
        <hr>
        <div class="form-group row">
            <div class="col-sm-2"></div>
            <div class="col-sm-10">
                <button type="submit" class="btn btn-primary">Sign in</button>
            </div>
        </div>
    </form>

@endsection


