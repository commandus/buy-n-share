// automatically generated by the FlatBuffers compiler, do not modify


#ifndef FLATBUFFERS_GENERATED_PURCHASE_BS_H_
#define FLATBUFFERS_GENERATED_PURCHASE_BS_H_

#include "flatbuffers/flatbuffers.h"

#include "buynshare_generated.h"

namespace bs {

inline const bs::Purchase *GetPurchase(const void *buf) {
  return flatbuffers::GetRoot<bs::Purchase>(buf);
}

inline bool VerifyPurchaseBuffer(
    flatbuffers::Verifier &verifier) {
  return verifier.VerifyBuffer<bs::Purchase>(nullptr);
}

inline void FinishPurchaseBuffer(
    flatbuffers::FlatBufferBuilder &fbb,
    flatbuffers::Offset<bs::Purchase> root) {
  fbb.Finish(root);
}

}  // namespace bs

#endif  // FLATBUFFERS_GENERATED_PURCHASE_BS_H_