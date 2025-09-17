<div class="position-relative">
    <div class="position-absolute end-0 top-0">
        <a href="{{ route('companies.show', $recruiter['companyName'] ? $recruiter['companyName'] : $recruiter['id']) }}"
            class="btn btn-primary">Voir ma page</a>
    </div>
</div>
<h5 class="fw-bold mb-4">Page entreprise</h5>

<div class="row">
    <div class="col-12 mb-3">
        <x-media-uploader :label="'bannière de l\'entreprise'" :medias="$recruiter['medias']" type="company_banner" context="company_page"
            target-type="recruiter" :title="'Bannière ' . $recruiter['companyName']" :target-id="$recruiter['id']" :isMultiple=false />

    </div>
</div>
