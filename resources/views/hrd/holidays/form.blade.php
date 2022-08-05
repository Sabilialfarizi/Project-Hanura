<div class="row">
    <div class="col-md-12">
        <div class="card shadow" id="card">
            <div class="card-body">

                <div class="form-group">
                    <label for="title">Nama</label>  
                    <input type="text" autofocus class="form-control" name="title" id="title"
                    value="{{ $Holidays->title ?? old('title')}}">
                </div>
                <div class="form-group">
                    <label for="holiday_date">Holiday Date</label>  
                    <input type="date" autofocus class="form-control" name="holiday_date" id="holiday_date"
                    value="{{ Carbon\Carbon::parse($Holidays->holiday_date ?? old('holiday_date'))->format('Y-m-d') }}">
                </div>
                <div class="form-group">
                    <div class="col-sm-1 offset-sm-0">
                        <button type="submit" class="btn btn-primary" id="submit">Submit</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
