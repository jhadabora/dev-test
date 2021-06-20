<h1>Filters</h1>
<form action="{{ route('characters') }}" class="mb-3">
    <div class="mb-3">
        <label for="filter-name" class="form-label">Name</label>
        <input type="text" class="form-control" id="filter-name" name="name" placeholder="All" value="{{ request('name') }}">
    </div>
    <div class="mb-3">
        <label for="filter-status" class="form-label">Status</label>
        <select id="filter-status" name="status" class="form-control" aria-label="Default select example">
            <option value="" {{ !in_array(request('status'), ['alive', 'dead', 'unknown']) ? 'selected' : '' }}>All</option>
<option value="alive" {{ request('status') === 'alive' ? 'selected' : '' }}>Alive</option>
<option value="dead" {{ request('status') === 'dead' ? 'selected' : '' }}>Dead</option>
<option value="unknown" {{ request('status') === 'unknown' ? 'selected' : '' }}>Unknown</option>
</select>
</div>
<div class="mb-3">
    <label for="filter-species" class="form-label">Species</label>
    <input type="text" class="form-control" id="filter-species" name="species" placeholder="All">
</div>
<div class="mb-3">
    <label for="filter-type" class="form-label">Type</label>
    <input type="text" class="form-control" id="filter-type" name="type" placeholder="All">
</div>
<div class="mb-3">
    <label for="filter-gender" class="form-label">Gender</label>
    <select id="filter-gender" name="gender" class="form-control" aria-label="Default select example">
        <option value="" {{ !in_array(request('gender'), ['female', 'male', 'genderless', 'unknown']) ? 'selected' : '' }}>All</option>
        <option value="female" {{ request('gender') === 'female' ? 'selected' : '' }}>Female</option>
        <option value="male" {{ request('gender') === 'male' ? 'selected' : '' }}>Male</option>
        <option value="genderless" {{ request('gender') === 'genderless' ? 'selected' : '' }}>Genderless</option>
        <option value="unknown" {{ request('gender') === 'unknown' ? 'selected' : '' }}>Unknown</option>
    </select>
</div>
<input type="submit" class="btn btn-primary">
</form>
