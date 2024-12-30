<div class="inner-banner">
    <div class="container">
        <h1 class="breadcrumb-title">
            {{translate($title)}}
        </h1>
      <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="{{route('home')}}">
            {{translate('Home')}}
            </a></li>
          <li class="breadcrumb-item active" aria-current="page">  {{translate($title)}}</li>
        </ol>
      </nav>
    </div>
</div>


