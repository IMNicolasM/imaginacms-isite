<div class="filter-{{$type}} filter-{{$type}}-layout-{{$layout}} filter-{{$name}}">

    @if($options && count($options)>0)

        <select class="form-control form-control-sm"
            wire:model="selectedOption" 
            wire:ignore>
            <option value="0">{{trans('isite::frontend.filter-location.all')}}</option>
            @foreach($options as $key => $option)
                <option value="{{$option->id}}">
                   {{$option->name}}
                </option>
            @endforeach
        </select>

    @endif
   
</div>

@section('scripts-owl')
    @parent

    <script>

        // emit To Parent Filter
        function emitToParentFilterLocation(selectedOptionId,updateItemList){

            //console.warn("FILTER LOCATION - FRONTEND - SELECTED OPTION: "+selectedOptionId)
            setTimeout(function(){

                window.livewire.emit('filtersGetData',{
                    'name' : 'location-range',
                    'filter' : {
                        'cityId':selectedOptionId  
                    },
                    'eventUpdateItemsList':updateItemList
                }) 

            }, 3000);
           
        }
       
        /*
        * Call Back - Response Api
        */
        function callback(data)
        {

            //console.warn(data)
            @this.city = data.city;
            @this.province = data.state;
            @this.country = data.country_name;
            @this.countryCode = data.country_code;
           
        }

        /*
        * Init Script Geolocation
        */
        function initGeolocation(){

            var script = document.createElement('script');
            script.type = 'text/javascript';
            script.src = 'https://geolocation-db.com/jsonp';
            var h = document.getElementsByTagName('script')[0];
            h.parentNode.insertBefore(script, h);
        }

        /**
        * Start Geolocation
        */
        @php ($cityIdSelectedSession = request()->session()->get('cityIdSelected'));

        // Not Exist Session
        // Value 0 = All / Todos
        @if(!$cityIdSelectedSession)
            initGeolocation()
        @else
            @if($cityIdSelectedSession!=0)
                emitToParentFilterLocation({{$cityIdSelectedSession}},true)
            @endif
        @endif
       
       

    </script>

@stop
