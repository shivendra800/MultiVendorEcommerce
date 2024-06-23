<div class="form-group">
    <label for="parent_id">Selct Category Level</label>
    <select class="form-control" id="parent_id" name="parent_id"  style="color:#000;">
        <option value="0" @if(isset($category['parent_id'])&& $category['parent_id']==0) selcted="" @endif>
            Main Category</option>
        @if(!empty($getCategories))
        @foreach ($getCategories as $parentcategory )
        <option value="{{ $parentcategory['id'] }}" @if(isset($category['parent_id'])&& $category['parent_id']==$parentcategory['id'] ) selcted="" @endif
        >{{ $parentcategory['category_name'] }}</option>

        @if(!empty($parentcategory['subcategories']))
        @foreach ($parentcategory['subcategories'] as $subcategory )
        <option value="{{ $subcategory['id'] }}" @if(isset($category['parent_id'])&& $category['parent_id']==$category['id'] )
        selcted="" @endif
        >&nbsp;&raquo;&nbsp;{{ $category['category_name'] }}</option>

        @endforeach
        @endif
        @endforeach
        @endif
    </select>
</div>
