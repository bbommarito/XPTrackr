require "rails_helper"

RSpec.describe "Health check" do
  it "returns status ok" do
    get health_path

    expect(response).to have_http_status(:ok)
    expect(response.content_type).to eq("application/json; charset=utf-8")

    json_response = JSON.parse(response.body)
    expect(json_response["status"]).to eq("ok")
  end
end
