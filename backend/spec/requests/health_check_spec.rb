require "rails_helper"

RSpec.describe "Health check" do
  it "returns status ok" do
    get health_path

    expect(response).to have_http_status(:ok)
    expect(response.body).to eq("ok")
  end
end